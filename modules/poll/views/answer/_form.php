<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Answer */
/* @var $form yii\widgets\ActiveForm */
$index = $model->id ? : 'new-'.$index;
$form = isset($form) ? $form : new \bariew\yii2Tools\widgets\ActiveForm(['init' => false]);
?>

<div class="answer-form">
    <?= $form->field($model, "[$index]title")->textInput(['maxlength' => true]) ?>
    <?= Html::a('<em class="glyphicon glyphicon-trash"></em>',
        ["material-rule/delete", 'id' => $model->id],
        [
            'class' => 'btn btn-default',
            'onclick' =>  '
                        $.get($(this).attr("href")),
                        $(this).parents("table").fadeOut().remove();
                        $.colorbox.resize();
                        return false;
                    '
        ]) ?>
</div>