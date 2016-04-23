<?php

namespace app\modules\poll\models;

use app\modules\code\models\PullRequest;
use bariew\yii2Tools\behaviors\AttachedRelationBehavior;
use bariew\yii2Tools\validators\ListValidator;
use Yii;
use yii\base\Event;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * This is the model class for table "{{%poll_question}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
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
    const TYPE_DEFAULT = 0;
    const TYPE_CODE_POLL_REQUEST = 1;

    const STATUS_OPEN = 0;
    const STATUS_CLOSED = 2;
    const STATUS_SUCCESS = 3;
    const STATUS_FAIL = 4;

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
            [['status', 'title'], 'required'],
            [['description'], 'string'],
            [['relation_id', 'title'], 'string', 'max' => 255],
            [['status'], ListValidator::className()],
            ['relation_id', 'required', 'when' => function(Question $data){
                return $data->type == Question::TYPE_CODE_POLL_REQUEST;
            }]
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
            ]
        ];
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
            static::TYPE_DEFAULT => Yii::t('modules/poll', 'Default'),
            static::TYPE_CODE_POLL_REQUEST => Yii::t('modules/poll', 'Poll Request'),
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
            static::STATUS_CLOSED => Yii::t('modules/poll', 'Closed'),
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
            static::STATUS_CLOSED => 'waring',
            static::STATUS_SUCCESS => 'success',
            static::STATUS_FAIL => 'danger',
        ];
    }

    public static function pollList()
    {
        $result = [];
        /** @var PullRequest[] $models */
        $models = (new PullRequest())->search([])->allModels;
        foreach ($models as $model) {
            $result[$model->getRelationId()] = $model->login . ': ' . $model->title;
        }
        return $result;
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
        if ($this->type != static::TYPE_CODE_POLL_REQUEST) {
            return null;
        }
        return PullRequest::getUrl(preg_replace('/^(\d+)_.*$/', '$1', $this->relation_id));
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
}
