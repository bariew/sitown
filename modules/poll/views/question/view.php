<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use bariew\yii2Tools\helpers\GridHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Question */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/poll', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('modules/poll', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('modules/poll', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            GridHelper::listFormat($model, 'status'),
            GridHelper::listFormat($model, 'type'),
            'relation_id',
            'title',
            'description:ntext',
            'created_at:date',
        ],
    ]) ?>

</div>
