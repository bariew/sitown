<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\poll\models\Question;
use app\modules\poll\models\Answer;
use app\modules\poll\models\Vote;

/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Vote */
/* @var $question app\modules\poll\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vote-form">

    <?php $form = ActiveForm::begin(); ?>
    <h3><?= $question->title ?></h3>
    <p><?= $question->description ?></p>
    <table class="table table-stripped">
        <tbody>
        <?php foreach($question->answers as $answer): ?>
        <tr>
            <td><?= $answer->title ?></td>
            <td><?= $answer->voteCount ?></td>
            <td><?= $model->isNewRecord
                    ? Html::radio('Vote[answer_id]', $model->answer_id == $answer->id, ['value' => $answer->id])
                    : ($model->answer_id == $answer->id ? '<i class="glyphicon glyphicon-ok"></i>' : '')
                ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('modules/poll', 'Save'), ['class' => 'btn btn-success  pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>