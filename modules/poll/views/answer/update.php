<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Answer */

$this->title = Yii::t('modules/poll', 'Update {modelClass}: ', [
    'modelClass' => 'Answer',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/poll', 'Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('modules/poll', 'Update');
?>
<div class="answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
