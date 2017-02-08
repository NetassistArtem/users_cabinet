<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\components\debugger\Debugger;

$this->title = Yii::t('cabinet', 'cabinet');

?>
<div class="site-about" id="cabinet-table" >
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class="table-responsive" id="user-data">

        <table class="table table-bordered  table-border-custom">
            <thead>
            <tr>
                <th colspan="3"><?= Yii::t('cabinet', 'user_info') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= Yii::t('cabinet', 'full_name') ?></td>
                <td colspan="2"><?= $user_data['fio'] ?></td>

            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'address') ?></td>
                <td colspan="2"><?= $user_data['address'] ?></td>

            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'phone_1') ?></td>
                <td><?php foreach($user_data['phone_all_array'] as $val): ?>
                    <p><?= $val; ?></p>
                    <?php endforeach;?>
                </td>
                <td rowspan="2" class="btn-custom"><a
                        href="/<?=$lang ?>/upravlenie-kabinetom#contact_change"><?= Yii::t('cabinet', 'edit_contact_details') ?></a>
                </td>
            </tr>

            <tr>
                <td><?= Yii::t('cabinet', 'email') ?></td>
                <td><?php foreach($user_data['email_array'] as $val): ?>
                        <p><?= $val; ?></p>
                    <?php endforeach;?>
                </td>

            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'login') ?></td>
                <td colspan="2"><?= $user_data['username'] ?></td>

            </tr>
            <tr id="finance">
                <td><?= Yii::t('cabinet', 'password') ?></td>
                <td><?= $user_data['password'] ?></td>
                <td class="btn-custom"><a
                        href="/<?=$lang ?>/upravlenie-kabinetom#password_change"><?= Yii::t('cabinet', 'change_password') ?></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered  table-border-custom">
            <thead>
            <tr>
                <th colspan="4"><?= Yii::t('cabinet', 'services') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td rowspan="2" colspan="2"><?= Yii::t('cabinet', 'account_balance') ?></td>
                <td><?= Yii::t('cabinet', 'account_balance') ?></td>
                <td><?= $user_data['account_balance'] ?> <?= $user_data['account_currency'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'credit') ?></td>
                <td><?= $user_data['account_credit'] ?> <?= $user_data['account_currency'] ?></td>
            </tr>
            <tr>
                <td rowspan="2"><?= Yii::t('cabinet', 'tariffs') ?></td>
                <td>Пакет "Безлимитный"</td>
                <td><?= Yii::t('cabinet', 'active_to') ?></td>
                <td> 25.08.17</td>
            </tr>
            <tr>
                <td>IPTV</td>
                <td> <?= Yii::t('cabinet', 'active_to') ?></td>
                <td> 16.12.17</td>
            </tr>
            <tr id="network">
                <td class="btn-custom" colspan="2"><a href="#"><?= Yii::t('cabinet', 'change_rate') ?></a></td>
                <td class="btn-custom" colspan="2"><a href="/<?=$lang ?>/oplata-uslug"><?= Yii::t('cabinet', 'take_credit') ?></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered  table-border-custom">
            <thead>
            <tr>
                <th colspan="3"><?= Yii::t('cabinet', 'network_settings') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td rowspan="5">IPv4</td>
                <td>IP № 1</td>
                <td><?= isset($user_data['ip_1']) ? $user_data['ip_1'] : $user_data['ip_real_constant'] ?></td>
            </tr>
            <tr>
                <td>IP № 2</td>
                <td><?= $user_data['ip_2'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'netmask_1') ?></td>
                <td><?= $user_data['netmask'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'netmask_2') ?></td>
                <td><?= $user_data['netmask2'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'gateway') ?></td>
                <td><?= $user_data['gw'] ?></td>
            </tr>
            <tr>
                <td colspan="2">SNTP</td>
                <td><?= $user_data['mx_string'] ?></td>
            </tr>

            <tr>
                <td rowspan="2">DNS</td>
                <td><?= Yii::t('cabinet', 'primary_dns') ?></td>
                <td><?= $user_data['dns1_ip'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'secondary_dns') ?></td>
                <td><?= $user_data['dns2_ip'] ?></td>
            </tr>
            <tr>
                <td rowspan="5">IPv6</td>
                <td>IPv6 №1</td>
                <td></td>
            </tr>
            <tr>
                <td>IPv6 №2</td>
                <td><?= $user_data['ipv6'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'netmask_1') ?></td>
                <td></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'netmask_2') ?></td>
                <td></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'gateway') ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">DNS v6</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
