<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Answer */
/* @var $form yii\widgets\ActiveForm */
$index = $model->id ? : 'new-'.$index;
$form = isset($form) ? $form : new \bariew\yii2Tools\widgets\ActiveForm(['init' => false]);
$deleteLink = Html::a('<em class="glyphicon glyphicon-trash"></em>',
    ["/poll/answer/delete", 'id' => $model->id],
    [
        'class' => 'btn btn-default',
        'onclick' =>  '
                $.get($(this).attr("href")),
                $(this).parent().parent().fadeOut().remove();
                $.colorbox.resize();
                return false;
            '
    ]
);?>

<div class="answer-form form-inline">
    <?= $form->field($model, "[$index]title", ['template' => "{input}{$deleteLink}{error}"])->label(false)->textInput(['maxlength' => true]) ?>
</div>