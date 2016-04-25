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

    <?=
    //$form->field($model, 'description')->widget(\kartik\markdown\MarkdownEditor::className(), ['showExport' => false])
//    $form->field($model, 'description')->widget(\franciscomaya\sceditor\SCEditor::className(), [
//        'options' => ['rows' => 6],
//        'clientOptions' => [
//            'plugins' => 'bbcode',
//            "toolbar" => "bold,italic,underline|source",
//            'style' => 'minified/themes/square.min.css',
//        ]
//    ])
//        $form->field($model, 'description')->widget(\trntv\aceeditor\AceEditor::className(), [
//            'mode'=>'html',
//            'theme'=>'github'
//        ])
    $form->field($model, 'description')->widget(\ijackua\lepture\Markdowneditor::className(), [
        'markedOptions' => [
            'tables' => false,
            'breaks' => true,
        ]
    ])
    ?>

    <?= $form->field($model, 'status')->dropDownList($model::statusList()) ?>

    <?php if($model->type == $model::TYPE_CODE_POLL_REQUEST) : ?>
        <?= $form->field($model, 'relation_id')->dropDownList($model::pollList()) ?>
    <?php endif; ?>

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
    <?php elseif($model->isNewRecord): ?>
        <div class="hide">
            <?php foreach([Yii::t('modules/poll', 'No'), Yii::t('modules/poll', 'Yes')] as $index => $title): ?>
                <?= $this->render('../answer/_form', [
                    'model' => new Answer(compact('title')), 'index' => $index, 'form' => $form
                ]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('modules/poll', 'Save'), ['class' => 'btn btn-success  pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
