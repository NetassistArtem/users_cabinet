<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BasicPage */

$this->title = 'Create Basic Page';
$this->params['breadcrumbs'][] = ['label' => 'Административная панель', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Basic Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="basic-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
