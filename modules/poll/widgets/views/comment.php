<?php

use yii\grid\GridView;
use bariew\yii2Tools\helpers\GridHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Comment */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="comment-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => '',
        'showOnEmpty' => false,
        'summary' => false,
        'showHeader' => false,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'options' => ['style' => 'width:10px']
            ],
            GridHelper::listFormat($model, 'user_id', [
                'options' => ['style' => 'width:60px']
            ]),
            'message',
        ],
    ]); ?>
</div>
<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->label(false)->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('modules/forum', 'Comment'), ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
