<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title =  Yii::t('cabinet','cabinet');

?>
<div class="site-about">
    <div class="title_custom" >
    <h1><?= Html::encode($this->title) ?></h1>
</div>


<div class="table-responsive" id="user-data">

    <table class="table table-bordered  table-border-custom" >
        <thead>
        <tr>
            <th colspan="3">Учетные данные</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>ФИО</td>
            <td colspan="2"><?= $user_data['fio'] ?></td>

        </tr>
        <tr>
            <td>Адрес</td>
            <td colspan="2" ><?= $user_data['address'] ?></td>

        </tr>
        <tr>
            <td>Телефон № 1</td>
            <td><?= $user_data['phone_1'] ?></td>
            <td rowspan="3" class="btn-custom"  ><a  href="/basic/web/upravlenie-kabinetom#contact_change"> Изменить контактные данные</a></td>
        </tr>

        <tr  >
            <td>Телефон № 2</td>
            <td><?= $user_data['phone_2'] ?></td>

        </tr>
        <tr>
            <td>Email</td>
            <td><?= $user_data['email'] ?></td>

        </tr>
        <tr>
            <td>Логин</td>
            <td colspan="2" ><?= $user_data['username'] ?></td>

        </tr>
        <tr id="finance" >
            <td>Пароль</td>
            <td><?= $user_data['password'] ?></td>
            <td class="btn-custom"  ><a  href="/basic/web/upravlenie-kabinetom#password_change"> Изменить пароль</a></td>
        </tr>
        </tbody>
    </table>
</div>

    <div class="table-responsive" >
        <table class="table table-bordered  table-border-custom" >
            <thead>
            <tr>
                <th colspan="4">Услуги</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td rowspan="2" colspan="2">Баланс</td>
                <td>Личные средства</td>
                <td><?= $user_data['account_balance'] ?> <?= $user_data['account_currency'] ?></td>
            </tr>
            <tr>
                <td >Кредитные средства</td>
                <td><?= $user_data['account_credit'] ?> <?= $user_data['account_currency'] ?></td>
            </tr>
            <tr>
                <td rowspan="2">Тарифы</td>
                <td>Пакет "Безлимитный"</td>
                <td> активен до:</td>
                <td> 25.08.17</td>
            </tr>
            <tr>
                <td>IPTV</td>
                <td> активен до:</td>
                <td> 16.12.17</td>
            </tr>
            <tr id="network" >
                <td class="btn-custom" colspan="2"><a  href="#"> Поменять тариф</a></td>
                <td class="btn-custom" colspan="2"><a  href="/basic/web/oplata-uslug"> Взять кредит</a></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive" >
        <table class="table table-bordered  table-border-custom" >
            <thead>
            <tr>
                <th colspan="3">Настройки сети</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td rowspan="5">IPv4</td>
                <td>IP № 1</td>
                <td><?= isset($user_data['ip_1']) ? $user_data['ip_1'] : $user_data['ip_real_constant'] ?></td>
            </tr>
            <tr>
                <td>IP  № 2</td>
                <td><?= $user_data['ip_2'] ?></td>
            </tr>
            <tr>
                <td>Маска сети №1</td>
                <td><?= $user_data['netmask'] ?></td>
            </tr>
            <tr>
                <td>Маска сети №2</td>
                <td><?= $user_data['netmask2'] ?></td>
            </tr>
            <tr>
                <td>Шлюз</td>
                <td><?= $user_data['gw'] ?></td>
            </tr>
            <tr>
                <td colspan="2">SNTP</td>
                <td ><?= $user_data['mx_string'] ?></td>
            </tr>

            <tr>
                <td rowspan="2">DNS</td>
                <td>Основной DNS</td>
                <td><?= $user_data['dns1_ip'] ?></td>
            </tr>
            <tr>
                <td>Дополнительный DNS</td>
                <td><?= $user_data['dns2_ip'] ?></td>
            </tr>
            <tr>
                <td rowspan="5">IPv6</td>
                <td>Правильный IPv6</td>
                <td></td>
            </tr>
            <tr>
                <td>Установленный IPv6</td>
                <td><?= $user_data['ipv6'] ?></td>
            </tr>
            <tr>
                <td>Маска сети</td>
                <td></td>
            </tr>
            <tr>
                <td>Шлюз</td>
                <td></td>
            </tr>
            <tr>
                <td>DNS v6</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>





</div>
