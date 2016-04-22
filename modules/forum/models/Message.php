<?php

namespace app\modules\forum\models;

use Yii;

/**
 * This is the model class for table "{{%forum_message}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topic_id
 * @property string $content
 * @property integer $created_at
 *
 * @property ForumTopic $topic
 * @property UserUser $user
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic_id', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => ForumTopic::className(), 'targetAttribute' => ['topic_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserUser::className(), 'targetAttribute' => ['user_id' => 'id']],
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
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(ForumTopic::className(), ['id' => 'topic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserUser::className(), ['id' => 'user_id']);
    }
}
