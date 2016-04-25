<?php

namespace app\modules\poll\models;

use app\modules\user\models\User;
use bariew\yii2Tools\behaviors\OwnerBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "poll_comment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $question_id
 * @property integer $created_at
 * @property string $message
 *
 * @property Question $question
 * @property User $user
 *
 * @mixin OwnerBehavior
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poll_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'question_id', 'created_at'], 'integer'],
            [['message'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modules/poll', 'ID'),
            'user_id' => Yii::t('modules/poll', 'User ID'),
            'question_id' => Yii::t('modules/poll', 'Question ID'),
            'created_at' => Yii::t('modules/poll', 'Created At'),
            'message' => Yii::t('modules/poll', 'Message'),
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
            OwnerBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function userList()
    {
        return User::listAll();
    }

    /**
     * @return ActiveDataProvider
     */
    public function search()
    {
        return new ActiveDataProvider([
            'query' => static::find()
                ->andFilterWhere(['question_id' => $this->question_id])
        ]);
    }
}
