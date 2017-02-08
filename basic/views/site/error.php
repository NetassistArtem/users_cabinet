<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

if($name == 'Not Found (#404)'|| $name == 'Not Found (#404)'){
    $name = Yii::t('error',$name);
}



$this->title = $name;
//$this->title = Yii::t('tv','tv');

?>
<div class="site-about">
    <div class="title_custom" >
        <h1><?= Html::encode($this->title) ?></h1>
    </div>



    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

</div>
