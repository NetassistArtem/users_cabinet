<?php
use yii\helpers\Html;

$this->title = Yii::t('tv','tv');

?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="content_tv">
        <div>
            <p>
                <i class="message_main_text"><?= Yii::t('tv','tv_on_net')?></i>
            </p>
            <p><?= Yii::t('site',Yii::$app->session->get('sites_data')['company_name']['lang_key'])?>    <?= Yii::t('tv','provide_ip_tv')?></p>
            <p><?= Yii::t('tv','channel_sample')?></p>
        </div>

    </div>


    <div class="table-responsive">
        <table class="table table-bordered  table-border-custom" >
            <thead>
            <tr>
                <th colspan="2"><?= Yii::t('tv','downloading')?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= Yii::t('tv','player')?></td>
                <td class="btn-custom" ><a  href="http://iptv.alfa-inet.net/files/alfa-IpTvPlayer-setup.exe"><?= Yii::t('tv','download')?></a></td>

            </tr>
            <tr>
                <td><?= Yii::t('tv','playlist')?></td>
                <td class="btn-custom" ><a  href="http://kuzia.net.ua/tv_playlist.m3u"><?= Yii::t('tv','download')?></a></td>

            </tr>

            </tbody>
        </table>
    </div>


</div>

