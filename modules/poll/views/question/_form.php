<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\poll\models\Answer;

/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(\ijackua\lepture\Markdowneditor::className(), [
        'markedOptions' => [
            'tables' => false,
            'breaks' => true,
        ]
    ])
    ?>

    <?php if($model->type == $model::TYPE_CUSTOM) : ?>
        <div class="form-group">
            <?= Html::a(Yii::t('modules/poll', 'Add answer'), ['/poll/answer/create'], [
                'class' => 'btn btn-primary',
                'onclick' => '
                var e = $(this);
                $.get(e.prop("href"), function(data){
                    e.next().append(data);
                    $.colorbox.resize();
                });
                return false;
            '
            ]) ?>

            <div class="question-answers">
                <br />
                <?php foreach($model->getRelationSavingModels('answers') as $index => $answer): ?>
                    <?= $this->render('../answer/_form', ['model' => $answer, 'index' => $index, 'form' => $form]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('modules/poll', 'Save'), ['class' => 'btn btn-success  pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
