<?php

namespace app\modules\poll\models;

use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%poll_vote}}".
 *
 * @property integer $answer_id
 * @property integer $user_id
 * @property integer $created_at
 *
 * @property Question $question
 * @property Answer $answer
 * @property User $user
 */
class Vote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poll_vote}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['answer_id', 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'answer_id' => Yii::t('modules/poll', 'Answer ID'),
            'user_id' => Yii::t('modules/poll', 'User ID'),
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->user_id = $this->user_id ? : Yii::$app->user->id;
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id'])->via('answer');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
