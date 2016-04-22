<?php

use yii\helpers\Html;
use yii\grid\GridView;
use bariew\yii2Tools\helpers\GridHelper;
use app\modules\code\models\PullRequest;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\code\models\PullRequest $searchModel
 */

$this->title = Yii::t('modules/code', 'Pull requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            'login',
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->title, $data->url, ['target' => '_blank']);
                }
            ],
            [
                'attribute' => 'poll',
                'format' => 'raw',
                'value' => function (PullRequest $data) {
                    return $data->getPoll() ? $data->getPoll()->getLink() : null;
                }
            ],
            [
                'attribute' => 'state',
                'format' => 'raw',
                'value' => function (PullRequest $data) {
                    return Html::dropDownList('state', $data->state, $data->stateList(), [
                        'href' => \yii\helpers\Url::to(['/code/pull-request/state']),
                        'prompt' => 'merge',
                        'onchange' => 'var e = $(this); $.post(e.attr("href"), {
                            state: e.val(),
                            sha: "'.$data->sha.'",
                            number: "'.$data->number.'"
                        })
                        .success(function(data){ e.addClass("bg-success"); })
                        .error(function(data){ e.addClass("bg-danger"); });'
                    ]);
                },
                'filter' => PullRequest::stateList()
            ],
        ],
    ]); ?>

</div>
