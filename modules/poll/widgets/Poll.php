<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 23.04.16
 * Time: 5:48
 */

namespace app\modules\poll\widgets;


use yii\base\Widget;
use app\modules\poll\models\Question;
use app\modules\poll\models\Vote;
use Yii;

class Poll extends Widget
{
    /** @var Question */
    public $question;

    public function run()
    {
        $vote = $this->question->getUserVote() ? : new Vote();
        if ($vote->isNewRecord && $vote->load(\Yii::$app->request->post()) && $vote->save()) {
            Yii::$app->controller->refresh();
            Yii::$app->end();
        }
        $answerQuery = $this->question->getAnswers()
            ->joinWith('votes')
            ->addSelect(['*', 'voteCount' => 'count(user_id)'])
            ->groupBy('id');
        return $this->render('poll', [
            'model' => $vote,
            'question' => $this->question,
            'answers' => $answerQuery->all(),
        ]);
    }
}