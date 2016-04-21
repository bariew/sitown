<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\user\models\UserSearch $searchModel
 */

$this->title = Yii::t('modules/code', 'Pull requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'login',
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->title, $data->url, ['target' => '_blank']);
                }
            ],
        ],
    ]); ?>

</div>
