<?php

use yii\helpers\Html;
use yii\grid\GridView;
use bariew\yii2Tools\helpers\GridHelper;
use app\modules\poll\models\Question;
use app\modules\code\models\PullRequest;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\poll\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('modules/poll', 'Questions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right"><?= \bariew\yii2Tools\helpers\HtmlHelper::linkDropdown(Yii::t('modules/poll', 'Create Question'), array_map(
            function(&$v) { return $v = ['/poll/question/create', 'type' => $v];},
            array_flip($searchModel::typeList())
        )) ?>
        </span>
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            'title',
            GridHelper::listFormat($searchModel, 'type'),
            'created_at:date',
            'url:url',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($data) {return $data->link;},
                'filter' => $searchModel::statusList(),
            ],
        ],
    ]); ?>
</div>
