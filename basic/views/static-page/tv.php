<?php
use yii\helpers\Html;

$this->title = 'Телевидение';

?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="content_tv">
        <div>
            <p>
                <i class="message_main_text">Телевидение в сети!</i>
            </p>
            <p>Компания Кузя совместно с парнером, предоставляет 150 каналов цифрового телевидения в формате IPTV.</p>
            <p>В список каналов входят "Канал 5", "TBi", "Громадське.ТВ" и многие другие.</p>
        </div>

    </div>


    <div class="table-responsive">
        <table class="table table-bordered  table-border-custom" >
            <thead>
            <tr>
                <th colspan="2">Загрузки</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Проигрыватель</td>
                <td class="btn-custom" ><a  href="http://iptv.alfa-inet.net/files/alfa-IpTvPlayer-setup.exe">Загрузить</a></td>

            </tr>
            <tr>
                <td>Плэй лист для проигрывателя или приставки</td>
                <td class="btn-custom" ><a  href="http://kuzia.net.ua/tv_playlist.m3u">Загрузить</a></td>

            </tr>

            </tbody>
        </table>
    </div>


</div>

