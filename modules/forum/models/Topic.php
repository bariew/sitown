<?php

namespace app\modules\forum\models;

use app\modules\user\models\User;
use bariew\yii2Tools\behaviors\OwnerBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "forum_topic".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $created_at
 *
 * @property Message[] $forumMessages
 * @property User $user
 *
 * @mixin OwnerBehavior
 */
class Topic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_topic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'id' => Yii::t('modules/forum', 'ID'),
            'user_id' => Yii::t('modules/forum', 'User ID'),
            'title' => Yii::t('modules/forum', 'Title'),
            'description' => Yii::t('modules/forum', 'Description'),
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
            OwnerBehavior::className()
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['topic_id' => 'id']);
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
}
