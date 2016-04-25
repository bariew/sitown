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
 * @property string $value
 *
 * @property Question $question
 * @property Vote[] $votes
 * @property User[] $users
 */
class Answer extends \yii\db\ActiveRecord
{
    public $voteCount;
    public $voteWinner;

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
            [['value'], 'unique', 'filter' => ['question_id' => $this->question_id]],
            [['title', 'value'], 'string', 'max' => 255],
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
            'value' => Yii::t('modules/poll', 'Value'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!strlen($this->value)) {
            $this->value = $this->question->getAnswers()->count();
        }

        return parent::beforeSave($insert);
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
        return $this->hasMany(User::className(), ['id' => 'user_id'])->via('votes');
    }
}
