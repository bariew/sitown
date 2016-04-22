<?php

namespace app\modules\poll\models;

use app\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%poll_answer}}".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $title
 *
 * @property Question $question
 * @property Vote[] $votes
 * @property User[] $users
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%poll_answer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
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
            'question_id' => Yii::t('modules/poll', 'Question ID'),
            'title' => Yii::t('modules/poll', 'Title'),
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
    public function getVotes()
    {
        return $this->hasMany(Vote::className(), ['answer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('{{%poll_vote}}', ['answer_id' => 'id']);
    }
}
