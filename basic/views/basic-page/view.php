<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BasicPage */

$this->title = $model->title;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="basic-page-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    <?= Html::encode($model->title) ?>

    </p>



</div>
