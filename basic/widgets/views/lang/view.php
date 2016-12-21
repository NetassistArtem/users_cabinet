<?php
use yii\helpers\Html;
?>

        <?php foreach ($lang_without_current as $lang):?>
    <li class="li_<?= $lang->url?>">
            <?= Html::a($lang->symbol, '/'.$lang->url.Yii::$app->getRequest()->getLangUrl()) ?>
    </li>

        <?php endforeach;?>
