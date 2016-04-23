<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('modules/forum', 'Create') : Yii::t('modules/forum', 'Update'),
            ['class' => 'btn btn-success pull-right']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
