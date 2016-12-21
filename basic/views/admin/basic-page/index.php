<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BasicPageSearche */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Basic Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="basic-page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Basic Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'text:ntext',
            'alias',
            'publish',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
