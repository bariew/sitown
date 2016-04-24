<?php

use yii\helpers\Html;
use bariew\yii2Tools\helpers\GridHelper;
use app\modules\forum\models\Message;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Topic */
/* @var $message app\modules\forum\models\MessageSearch */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/forum', 'Forum'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <?php if($model->isAccessible()) : ?>
            <?= Html::a(Yii::t('modules/forum', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary pull-right']) ?>
        <?php endif; ?>
    </h1>

    <p>
        <?= $model->description ?>
    </p>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $message->search([]),
        'emptyText' => '',
        'showOnEmpty' => false,
        'summary' => false,
        'showHeader' => false,
        'columns' => [
            GridHelper::listFormat($message, 'user_id', [
                'options' => ['style' => 'width:60px']
            ]),
            'content',
        ],
    ]); ?>

    <?= $this->render('_messageForm', ['model' => $message]) ?>
</div>
