<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Answer */

$this->title = Yii::t('modules/poll', 'Create Answer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/poll', 'Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
