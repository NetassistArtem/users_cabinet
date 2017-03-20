<?php

use yii\helpers\Html;
use app\components\debugger\Debugger;
use yii\widgets\LinkPager;


$this->title = Yii::t('arhiv-news', 'arhiv_title');

?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php foreach ($archive_data_page as $k => $v): ?>
        <div class="content_tv">

            <?php if (!$v['view']): ?>
                <div class="alert alert-danger alert-custom">
                    <p>
                        <?= Yii::t('arhiv-news', 'message_not_reade'); ?>
                    </p>
                </div>
            <?php endif; ?>
            <h3 class="arhiv_news_title"><?= $v['date'] ?></h3>

            <div>
                <?php if ($v['short_text']): ?>
                    <p><?= $v['short_text'] ?></p>
                <?php else: ?>
                    <p><?= $v['text'] ?></p>
                <?php endif; ?>
            </div>
            <?php if($v['short_text']):?>
            <div class="btn-custom"><a href="/<?= $lang ?>/arhiv-novostei/<?= $v['id'] ?>"><?= Yii::t('arhiv-news', 'reade_more') ?></a></div>
                <?php elseif(!$v['view'] && !$v['short_text']): ?>
                <div class="btn-custom"><a href="/<?= $lang ?>/arhiv-novostei/reade/<?= $v['id'] ?>"><?= Yii::t('arhiv-news', 'reade_confirm') ?></a></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="col-lg-12 col-md-12 col-sm-12 pagination-custom">
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>

    </div>
</div>