<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Административная панель';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Управлние стандартными страницами (Basic Page)', ['/admin/basic_page'], ['class' => 'btn btn-primary']) ?>
    </p>

    <code><?= __FILE__ ?></code>
</div>
