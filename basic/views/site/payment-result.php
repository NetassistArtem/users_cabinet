<?php
use yii\helpers\Html;


$this->title = $result == 1? Yii::t('payment-result','payment-ok') : Yii::t('payment-result','payment-fail');
//$this->title = Yii::t('tv','tv');

?>
<div class="site-about">
    <div class="title_custom" >
        <h1><?= Html::encode($this->title) ?></h1>
    </div>





<?php if($result == 1): ?>

    <div class="alert alert-success">
        <?= Yii::t('payment-result','payment-ok-text') ?>
    </div>
<?php elseif($result == -1): ?>

    <div class="alert alert-danger">
        <?= Yii::t('payment-result','payment-fail-text') ?>
    </div>
    <?php else:?>
    <div class="alert alert-danger">
        <?= Yii::t('payment-result','payment-fail-text') ?>
    </div>
<?php endif; ?>


</div>