<?php

namespace app\modules\forum\models;

use Yii;

/**
 * This is the model class for table "{{%forum_vote}}".
 *
 * @property integer $user_id
 * @property integer $topic_id
 * @property integer $result
 *
 * @property ForumTopic $topic
 * @property UserUser $user
 */
class Vote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_vote}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic_id'], 'required'],
            [['user_id', 'topic_id', 'result'], 'integer'],
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
            'user_id' => Yii::t('modules/forum', 'User ID'),
            'topic_id' => Yii::t('modules/forum', 'Topic ID'),
            'result' => Yii::t('modules/forum', 'Result'),
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
