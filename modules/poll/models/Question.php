<?php

namespace app\modules\poll\models;

use app\modules\user\models\User;
use bariew\yii2Tools\behaviors\AttachedRelationBehavior;
use bariew\yii2Tools\behaviors\SerializeBehavior;
use Yii;
use yii\base\Event;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\web\HttpException;

/**
 * This is the model class for table "{{%poll_question}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property Event $event_object
 * @property string $relation_id
 * @property string $title
 * @property string $description
 * @property integer $created_at
 *
 * @property Answer[] $answers
 * @property Vote[] $votes
 *
 * @mixin AttachedRelationBehavior
 */
class Question extends \yii\db\ActiveRecord
{
    const TYPE_CUSTOM = 0;
    const TYPE_DICHOTOMOUS = 1;

    const STATUS_OPEN = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poll_question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modules/poll', 'ID'),
            'status' => Yii::t('modules/poll', 'Status'),
            'type' => Yii::t('modules/poll', 'Type'),
            'relation_id' => Yii::t('modules/poll', 'Related To'),
            'title' => Yii::t('modules/poll', 'Title'),
            'description' => Yii::t('modules/poll', 'Description'),
            'created_at' => Yii::t('modules/poll', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [static::EVENT_BEFORE_INSERT => ['created_at'],]
            ],
            'attachedRelations' => [
                'class' => AttachedRelationBehavior::className(),
                'relations' => ['answers']
            ],
            [
                'class' => SerializeBehavior::className(),
                'type' => SerializeBehavior::TYPE_PHP,
                'attributes' => ['event_object']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (!$this->id && $this->type == static::TYPE_DICHOTOMOUS) {
            $post = Yii::$app->request->bodyParams;
            $post[(new Answer())->formName()] = [
                'new-0' => ['title' => Yii::t('app', 'No'), 'value' => "0"],
                'new-1' => ['title' => Yii::t('app', 'Yes'), 'value' => "1"],
            ];
            Yii::$app->request->bodyParams = $post;
        }
        return parent::beforeValidate();
    }

    /** For form validation */
    public function setAnswers() {}

    /**
     * Available type list
     * @return array
     */
    public static function typeList()
    {
        return [
            static::TYPE_CUSTOM => Yii::t('modules/poll', 'Custom'),
            static::TYPE_DICHOTOMOUS => Yii::t('modules/poll', 'Yes/No'),
        ];
    }

    /**
     * Available status list
     * @return array
     */
    public static function statusList()
    {
        return [
            static::STATUS_OPEN => Yii::t('modules/poll', 'Opened'),
            static::STATUS_SUCCESS => Yii::t('modules/poll', 'Success'),
            static::STATUS_FAIL => Yii::t('modules/poll', 'Fail'),
        ];
    }

    /**
     * Available status list
     * @return array
     */
    public static function statusLabelList()
    {
        return [
            static::STATUS_OPEN => 'info',
            static::STATUS_SUCCESS => 'success',
            static::STATUS_FAIL => 'danger',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(Vote::className(), ['answer_id' => 'id'])->via('answers');
    }

    /**
     * @param null $user_id
     * @return Vote|null
     */
    public function getUserVote($user_id = null)
    {
        $user_id = $user_id ?: Yii::$app->user->id;
        return $this->getVotes()->andWhere(compact('user_id'))->one();
    }

    public function getLink()
    {
        return Html::a(
            static::statusList()[$this->status],
            ['/poll/default/view', 'id' => $this->id],
            ['class' => 'bg-'.static::statusLabelList()[$this->status]]
        );
    }

    public function getUrl()
    {
        if (!$event = $this->event_object) {
            return null;
        }
        /** @var Model $model */
        $model = $event->sender;
        return @$model->id
            ? Yii::$app->urlManager->createAbsoluteUrl([
                preg_replace(
                    '#.*app\\\\modules\\\\(\w+)\\\\models\\\\(\w+)#',
                    '/$1/$2/view',
                    strtolower(get_class($model))
                ),
                'id' => $model->id
            ])
            : null;
    }

    public function isSuccess()
    {
        return $this->status == static::STATUS_SUCCESS;
    }

    public function isOpen()
    {
        return $this->status == static::STATUS_OPEN;
    }

    public function close()
    {

    }

    public static function getRelationId($model)
    {
        return $model->id ? get_class($model).'_'.$model->id : null;
    }

    public static function getRelationTitle($model)
    {
        foreach (['title', 'name', 'username', 'email', 'id'] as $attribute) {
            if (isset($model->$attribute) && ($result = $model->$attribute)) {
                return $result;
            }
        }
        return null;
    }

    private static $isTriggeredByPoll = false;
    public static function modelEventHandler(Event $event)
    {
        /** @var Model $model */
        $model = $event->sender;
        if (static::$isTriggeredByPoll) {
            return;
        }
        (new static([
            'title' => "(auto) ". $model->formName() . ' "'. static::getRelationTitle($model).'"',
            'description' => "Triggered by event '{$event->name}'",
            'status' => static::STATUS_OPEN,
            'type' => static::TYPE_DICHOTOMOUS,
            'relation_id' => static::getRelationId($model),
            'event_object' => $event,
        ]))->save();
        throw new HttpException(451, Yii::t('modules/poll', 'These changes will be applied after a successful poll.'));
    }

    public static function voteAfterInsertHandler(Event $event)
    {
        /** @var Vote $vote */
        $vote = $event->sender;
        $userCount = User::find()->count();
        $question = $vote->question;
        $votes = $question->getVotes()->with('answer')->select('answer.value')->column();
        $voteCount = count($votes);
        $voteSum = array_sum($votes);
        $voteLeft = $userCount - $voteCount;
        $voteDiff = $voteCount - $voteSum;
        if ($voteSum > ($voteDiff + $voteLeft)) { // negative voices can't be more than positive
            $question->status = $question::STATUS_SUCCESS;
        } elseif ($voteSum < ($voteDiff - $voteLeft)) { // positive votes can't be more than negative
            $question->status = $question::STATUS_FAIL;
        } else {
            return;
        }
        $question->save();
    }
}
