<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Vote */
/* @var $question app\modules\poll\models\Question */
/* @var $answers app\modules\poll\models\Answer[] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vote-form">

    <?php $form = ActiveForm::begin(); ?>
    <h3><?= $question->title ?></h3>
    <p><?= $question->isAuto()
            ? '<pre>'.$question->description.'</pre>'
            : \yii\helpers\Markdown::process($question->description);
        ?></p>
    <table class="table table-stripped">
        <tbody>
        <?php foreach($answers as $answer): ?>
        <tr>
            <td><?= $answer->title ?></td>
            <td><?= $answer->voteCount ?></td>
            <td><?= $model->isNewRecord && $question->isOpen()
                    ? Html::radio('Vote[answer_id]', $model->answer_id == $answer->id, [
                        'value' => $answer->id,
                        'onchange' => '$(this).parents("form").submit();'
                    ])
                    : ($model->answer_id == $answer->id ? '<i class="glyphicon glyphicon-ok"></i>' : '')
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php ActiveForm::end(); ?>

</div>