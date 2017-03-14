<?php

use yii\helpers\Html;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = Yii::t('arhiv-news', 'arhiv_title');

?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php Pjax::begin(['id' => 'arhiv_news']); ?>

    <?php Pjax::end(); ?>


</div>