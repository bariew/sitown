<?php

use yii\helpers\Html;
use yii\grid\GridView;
use bariew\yii2Tools\helpers\GridHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\forum\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('modules/forum', 'Forum');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <?= Html::a(Yii::t('modules/forum', 'Create Topic'), ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::a($data->title, ['view', 'id' => $data->id]);
                }
            ],
            GridHelper::listFormat($searchModel, 'user_id'),
            GridHelper::dateFormat($searchModel, 'created_at'),
        ],
    ]); ?>
</div>
