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
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'url:url',
            'created_at:date',
            'link:raw'
        ],
    ]); ?>
</div>
