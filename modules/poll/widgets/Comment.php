<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 25.04.16
 * Time: 7:32
 */

namespace app\modules\poll\widgets;


use yii\base\Widget;

class Comment extends Widget
{
    public $question;

    public function run()
    {
        $model = new \app\modules\poll\models\Comment(['question_id' => $this->question->id]);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $model = new \app\modules\poll\models\Comment(['question_id' => $this->question->id]);
        }
        return $this->render('comment', [
            'model' => $model,
            'dataProvider' => $model->search(),
        ]);
    }
}