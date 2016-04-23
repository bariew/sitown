<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Topic */

$this->title = Yii::t('modules/forum', 'Update {modelClass}: ', [
    'modelClass' => 'Topic',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/forum', 'Topics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('modules/forum', 'Update');
?>
<div class="topic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
