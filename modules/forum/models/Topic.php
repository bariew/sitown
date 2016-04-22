<?php

namespace app\modules\forum\models;

use Yii;

/**
 * This is the model class for table "{{%forum_topic}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string $title
 * @property string $description
 * @property string $pull_request_url
 * @property integer $created_at
 *
 * @property ForumMessage[] $forumMessages
 * @property UserUser $user
 * @property ForumVote[] $forumVotes
 * @property UserUser[] $users
 */
class Topic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_topic}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['title', 'pull_request_url'], 'string', 'max' => 255],
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
            'type' => Yii::t('modules/forum', 'Type'),
            'title' => Yii::t('modules/forum', 'Title'),
            'description' => Yii::t('modules/forum', 'Description'),
            'pull_request_url' => Yii::t('modules/forum', 'Pull Request Url'),
            'created_at' => Yii::t('modules/forum', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumMessages()
    {
        return $this->hasMany(ForumMessage::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumVotes()
    {
        return $this->hasMany(ForumVote::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(UserUser::className(), ['id' => 'user_id'])->viaTable('{{%forum_vote}}', ['topic_id' => 'id']);
    }
}
