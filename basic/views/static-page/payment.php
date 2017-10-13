<?php
use yii\helpers\Html;
use app\components\debugger\Debugger;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use app\assets\AppAsset;

$this->title = Yii::t('payment', 'payment');


?>
    <div class="site-about">
        <div class="title_custom">
            <h1 id="title-h1-payment"><?= Html::encode($this->title) ?></h1>
        </div>

        <div>
            <input class="insert-test" name="_csrf" type="hidden" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
        </div>

        <div class="table-responsive table_payment payment_next_information mergin_bottom">
            <?php

            $credit_limit = $user_data['account_max_credit'];


            $included = 1;
            //    $verbose = 1;

            global $db;
            global $pdb;
            global $bkdb;
            global $adb;
            global $dblink;
            global $alt_db;
            global $alt_pdb;
            global $is_admin;
            global $request_vars;
            //   global $alfa_url;
            //   $alfa_url = 7;

            // $request_vars['user_name'] = Yii::$app->user->identity->username;


            global $auth_user_name;
            // $auth_user_name = Yii::$app->user->identity->username;
            global $auth_acc_id;
            global $auth_user_id;             //= Yii::$app->user->id;
            global $auth_group_id;
            global $htpasswd_auth_ok;
            global $lang_str;
            global $supported_langs;

            //  Debugger::PrintR($request_vars);
            // Debugger::PrintR($_SESSION);
            // Debugger::Eho($auth_user_name. 'test');
            // Debugger::Eho('</br>/n');
            // Debugger::Eho($auth_user_id. 'test');
            //  Debugger::EhoBr($lang_str);
            // Debugger::PrintR($supported_langs);

            // Debugger::PrintR($_SESSION);


            include(dirname(dirname(__DIR__)) . '/components/billing_api/admin/wm.php');


            ?>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered  table-border-custom">
                <thead>
                <tr>
                    <th colspan="3"><?= Yii::t('payment', 'other_pay_method') ?></th>
                </tr>
                </thead>
                <tbody>
                <tr class="center">
                    <td class="btn-custom"><a
                            href="/<?= $lang ?>/oplata-uslug/terminals"><?= Yii::t('payment', 'pay_by_terminals') ?></a>
                    </td>
                    <td>
                        <img src="/images/wm/otyme_small.png" alt="tyme">
                        <img src="/images/wm/city244_small.png" alt="citypay">
                        <img src="/images/wm/24nonstop24_small.gif" alt="citypay">
                    </td>
                    <td> 3-5%</td>
                </tr>
                <tr class="center">
                    <td class="btn-custom"><a
                            href="/<?= $lang ?>/oplata-uslug/bank"><?= Yii::t('payment', 'pay_by_bank') ?></a></td>
                    <td><i class="fa fa-university fa-3x" aria-hidden="true"></i></td>
                    <td> 5-15 <?= Yii::t('payment', 'uan') ?> </td>
                </tr>
                </tbody>
            </table>
        </div>


        <div id="credit"></div>
        <div class=" panel panel-default cabinet_change_forms">
            <div class="panel-heading">
                <p><?= Yii::t('payment', 'credit_t') ?></p>
            </div>
            <div class="panel-body">


                <?php Pjax::begin(['id' => 'credit_pay']); ?>
                <div>

                    <?php
                    $flash_message = Yii::$app->session->getFlash('credit')['value'];

                    if (isset($flash_message)):


                        // $this->registerJs('$("#modal").modal("show");');
                        echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);

                    endif;
                    ?>

                </div>


                <?php if ($credit_status === 0)://array_search(3, $user_data['services_status_num']) !== false && $user_data['account_max_credit'] != 0): ?>
                    <div class="alert alert-success">
                        <p>
                            <?= Yii::t('payment', 'amount_max_info') . $credit_limit . ' ' . $user_data['account_currency'] . '(' .$max_days .Yii::t('payment', 'days'). ')'; ?>
                        </p>
                    </div>

                    <?php $form_credit = ActiveForm::begin([
                        'id' => 'creditForm',
                        'options' => ['data-pjax' => false],
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                        ],


                    ]); ?>


                    <?= $form_credit->field($modelCredit, 'many')->label(Yii::t('payment', 'credit_amount'))->input('number', ['max' => $credit_limit, 'min' => 1]) ?>

                    <div class="form-group">


                        <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                            <?= Html::submitButton(Yii::t('payment', 'take_credit'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'credit-button', 'value' => 1]) ?>
                        </div>

                    </div>


                    <?php ActiveForm::end(); ?>

                <?php else: ?>


                    <?php if ($credit_status == -3): ?>
                        <div class="alert alert-success">
                            <p>
                                <?= Yii::t('payment', 'activation_services'); ?>
                            </p>
                        </div>
                    <?php elseif ($credit_status == -4): ?>
                        <div class="alert alert-warning">
                            <p>
                                <?= Yii::t('payment', 'tariff_no_credit'); ?>
                            </p>
                        </div>
                    <?php elseif ($credit_status === -5): ?>
                        <div class="alert alert-success">
                            <p>
                                <?= Yii::t('payment', 'not_need_credit'); ?>
                            </p>
                        </div>
                    <?php elseif ($credit_status == -6 ): ?>
                        <div class="alert alert-danger">
                            <p>
                                <?= Yii::t('payment', 'no_credit_large_delta'); ?>

                            </p>
                            <p>
                                <?= Yii::t('payment', 'delta') . $delta . Yii::t('payment', 'uan') ?>
                            </p>
                        </div>
                        <div class="alert alert-info">
                            <div class="icon_info icon_info_2">
                                <i class="fa fa-info-circle fa-3x" aria-hidden="true"></i>
                            </div>
                            <div class="text_mwssage text_mwssage_2">
                                <p>
                                    <?= Yii::t('payment', 'month_pay'). $monthly . Yii::t('payment', 'uan') ; ?>
                                </p>
                                <p>
                                    <?= Yii::t('payment', 'max_credit_calculate') . $max_credit . Yii::t('payment', 'uan') . ' ('.$max_days . Yii::t('payment', 'days'). ')'; ?>
                                </p>
                                <p>
                                    <?= Yii::t('payment', 'one_day_credit') . $one_day_credit . Yii::t('payment', 'uan') ?>
                                </p>
                            </div>


                        </div>

                        <?php elseif ( $credit_status == -7): ?>
                        <div class="alert alert-danger">
                            <p>
                                <?= Yii::t('payment', 'no_credit_large_delta'); ?>

                            </p>
                            <p>
                                <?= Yii::t('payment', 'delta') . $delta . Yii::t('payment', 'uan') ?>
                            </p>
                        </div>
                        <div class="alert alert-info">
                            <div class="icon_info icon_info_2">
                                <i class="fa fa-info-circle fa-3x" aria-hidden="true"></i>
                            </div>
                            <div class="text_mwssage text_mwssage_2">
                                <p>
                                    <?= Yii::t('payment', 'month_pay'). $monthly . Yii::t('payment', 'uan')  ; ?>
                                </p>
                                <p>
                                    <?= Yii::t('payment', 'many_minus') . $minus_many . Yii::t('payment', 'uan')  . ' ('.$max_days0 . Yii::t('payment', 'days'). ')' ; ?>
                                </p>
                                <p>
                                    <?= Yii::t('payment', 'max_credit_calculate') . $max_credit_2 . Yii::t('payment', 'uan') . ' ('.$max_days . Yii::t('payment', 'days'). ')'; ?>
                                </p>
                            </div>


                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <p>
                                <?= Yii::t('payment', 'no_credit_available'); ?>
                            </p>
                        </div>
                    <?php endif; ?>


                <?php endif; ?>
                <?php Pjax::end(); ?>


            </div>
        </div>


    </div>

<?php

$this->registerJsFile(
    'scripts/remove_credit_opt.js',
    ['depends' => 'app\assets\AppAsset']
);

?>