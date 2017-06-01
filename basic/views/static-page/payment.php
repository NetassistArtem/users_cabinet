<?php
use yii\helpers\Html;
use app\components\debugger\Debugger;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use app\assets\AppAsset;

$this->title =  Yii::t('payment','payment');




?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div >
        <input class="insert-test" name="_csrf" type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" />
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

        global $auth_user_name;    //= Yii::$app->user->identity->username;
        global $auth_acc_id;
        global $auth_user_id;             //= Yii::$app->user->id;
        global $auth_group_id;
        global $htpasswd_auth_ok;

       // Debugger::PrintR($request_vars);
       // Debugger::PrintR($_SESSION);
       // Debugger::Eho($auth_user_name. 'test');
       // Debugger::Eho('</br>/n');
       // Debugger::Eho($auth_user_id. 'test');
       // Debugger::Eho('</br>/n');
       // Debugger::PrintR($_SESSION);

        include (dirname(dirname(__DIR__)) . '/components/billing_api/admin/wm.php');


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
                <td class="btn-custom"><a href="/<?=$lang ?>/oplata-uslug/terminals"><?= Yii::t('payment', 'pay_by_terminals') ?></a></td>
                <td >
                    <img src="/images/wm/otyme_small.png" alt="tyme">
                    <img src="/images/wm/city244_small.png" alt="citypay">
                    <img src="/images/wm/24nonstop24_small.gif" alt="citypay">
                </td>
                <td> 3-5% </td>
            </tr>
            <tr class="center">
                <td class="btn-custom"><a href="/<?=$lang ?>/oplata-uslug/bank"><?= Yii::t('payment', 'pay_by_bank') ?></a></td>
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


            <?php if($user_data['account_max_credit'] != 0): ?>
            <div class="alert alert-success">
                <p>
                    <?= Yii::t('payment', 'amount_max_info'). $credit_limit.' '. $user_data['account_currency']; ?>
                </p>
            </div>

                <?php $form_credit = ActiveForm::begin([
                    'id' => 'creditForm',
                    'options' => ['data-pjax' => true],
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

                <div class="alert alert-success">
                    <p>
                        <?= Yii::t('payment', 'no_credit_available'); ?>
                    </p>
                </div>

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