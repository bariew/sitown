<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use bariew\yii2Tools\helpers\GridHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\poll\models\Question */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/poll', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \app\modules\poll\widgets\Poll::widget(['question' => $model]) ?>
