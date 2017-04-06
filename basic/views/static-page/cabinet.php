
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
                <td colspan = 2><?php foreach($user_data['phone_all_array'] as $val): ?>
                    <p><?= $val; ?></p>
                    <?php endforeach;?>
                </td>
            </tr>


            <tr>
                <td><?= Yii::t('cabinet', 'email') ?></td>
                <td colspan = 2><?php foreach($user_data['email_array'] as $val): ?>
                        <p><?= $val; ?></p>
                    <?php endforeach;?>
                </td>

            </tr>
            <tr>
                <td colspan = 3 class="btn-custom">
                    <a href="/<?=$lang ?>/upravlenie-kabinetom#contact_change"><?= Yii::t('cabinet', 'edit_contact_details') ?></a>
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
                <th colspan="3"><?= Yii::t('cabinet', 'account_balance_title') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= Yii::t('cabinet', 'account_balance') ?></td>
                <td><?= $user_data['account_balance'] ?> <?= $user_data['account_currency'] ?></td>
                <td class="btn-custom" rowspan="2"><a href="/<?=$lang ?>/oplata-uslug#credit"><?= Yii::t('cabinet', 'take_credit') ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'credit') ?></td>
                <td><?= $user_data['account_credit'] ?> <?= $user_data['account_currency'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>


    <div class="table-responsive">
        <table class="table table-bordered  table-border-custom">
            <thead>
            <tr>
                <th colspan="5"><?= Yii::t('cabinet', 'services') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= Yii::t('cabinet', 'serv') ?></td>
                <td><?= Yii::t('cabinet', 'tariff') ?></td>
                <td><?= Yii::t('cabinet', 'price_monthly') ?></td>
                <td><?= Yii::t('cabinet', 'services_end') ?></td>
                <td><?= Yii::t('cabinet', 'services_status') ?></td>
            </tr>
            <?php foreach($user_data['services'] as $k => $v): ?>
            <tr>
                <td><?= $v; ?></td>
                <td><?= $user_data['services_tariff_name'][$k]; ?></td>
                <td><?= $user_data['services_tariff_month_price'][$k]; ?> <?= $user_data['account_currency'] ?></td>
                <td><?= $user_data['services_date'][$k]; ?></td>


                <?php if($user_data['services_status_num'][$k] == -2): ?>
                    <?php $text = $user_data['services_status'][$k]. Yii::t('cabinet', 'with'). $user_data['svc_pause_date_start'][$k]; ?>
                <?php else: ?>
                    <?php $text = $user_data['services_status'][$k]; ?>
                <?php endif; ?>
                <?php if((int)$user_data['svc_auto_activation'][$k] === 0): ?>
                    <td><?= $text; ?></td>
                <?php elseif($user_data['svc_auto_activation'][$k] == 1): ?>
                    <td><?= $text; ?> <?= Yii::t('cabinet', 'auto_activation'); ?></td>
                <?php elseif($user_data['svc_auto_activation'][$k] >= 2): ?>
                    <td><?= $text; ?> <?= Yii::t('cabinet', 'auto_activation'); ?> <?= Yii::t('cabinet', 'auto_activation_number'); ?> <?= $user_data['svc_activation_number'][$k]; ?></td>
                <?php endif; ?>
            </tr>


            <?php endforeach; ?>

            <tr id="network">
                <td class="btn-custom" colspan="5"><a href="/<?=$lang ?>/upravlenie-kabinetom#services_change"><?= Yii::t('cabinet', 'change_services') ?></a></td>
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
                <td rowspan="6">IPv6</td>
                <td>IPv6</td>
                <td><?= $user_data['ipv6'] ?></td>
            </tr>

            <tr>
                <td><?= Yii::t('cabinet', 'netmask_1') ?></td>
                <td><?= $user_data['netmask6'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'gateway') ?></td>
                <td><?= $user_data['gw6'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'client_address') ?></td>
                <td><?= $user_data['cli_v6_net'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'client_router_address') ?></td>
                <td><?= $user_data['cli_v6_gw'] ?></td>
            </tr>
            <tr>
                <td><?= Yii::t('cabinet', 'client_mask') ?></td>
                <td><?= $user_data['cli_v6_mask'] ?></td>
            </tr>
            <?php foreach($user_data['ipv6_dns_array'] as $k=>$v ): ?>
            <tr>

                <?php if($k === 0): ?>
                    <td rowspan="<?= count($user_data['ipv6_dns_array']) ?>" >DNS v6</td>
               <?php endif; ?>
                <td>DNS v6 №<?= $k+1 ?> </td>
                <td><?= $v ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
