<?php
use yii\helpers\Html;
use app\components\debugger\Debugger;


$this->title = Yii::t('arhiv-news', 'news_item_title').'№ '.$arhiv_data_news['id'] . '('. $arhiv_data_news['date'] . ')';

?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="content_tv">
        <div>
            <p><?= $arhiv_data_news['text'] ?></p>
        </div>

    </div>

</div>