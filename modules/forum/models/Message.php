<?php

namespace app\modules\forum\models;

use app\modules\user\models\User;
use bariew\yii2Tools\behaviors\OwnerBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "forum_message".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topic_id
 * @property string $content
 * @property integer $created_at
 *
 * @property Topic $topic
 * @property User $user
 *
 * @mixin OwnerBehavior
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modules/forum', 'ID'),
            'user_id' => Yii::t('modules/forum', 'User ID'),
            'topic_id' => Yii::t('modules/forum', 'Topic ID'),
            'content' => Yii::t('modules/forum', 'Content'),
            'created_at' => Yii::t('modules/forum', 'Created At'),
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
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Available user list
     * @return array
     */
    public static function userList()
    {
        return User::listAll();
    }

    /**
     * @return array
     */
    public static function topicList()
    {
        return Topic::find()
            ->indexBy('id')
            ->select('title')
            ->column();
    }
}
