<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Question */

$this->title = Yii::t('modules/poll', 'Create Question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/poll', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
