<?php

namespace app\modules\poll\models;

use app\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%poll_vote}}".
 *
 * @property integer $answer_id
 * @property integer $user_id
 * @property integer $created_at
 *
 * @property Answer $answer
 * @property UserUser $user
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
        return [];
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
