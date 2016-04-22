<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList($model::statusList()) ?>

    <?= $form->field($model, 'type')->dropDownList($model::typeList()) ?>

    <?= $form->field($model, 'relation_id')->dropDownList($model::pollList(), ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::a(Yii::t('modules/poll', 'Add answer'), ['answer/create'], [
            'class' => 'btn btn-primary',
            'onchange' => '
                var e = $(this);
                $.get(e.data("href"), function(data){
                    e.next().append(data);
                    $.colorbox.resize();
                });
                return false;
            '
        ]) ?>
        <div class="question-answers">
            <?php foreach($answers as $index => $answer): ?>
                <?= $this->render('../answer/_form',
                    ['model' => $answer, 'index' => $index, 'form' => $form]) ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('modules/poll', 'Create') : Yii::t('modules/poll', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
