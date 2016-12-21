<?php
use yii\helpers\Html;
use app\components\debugger\Debugger;

$this->title = 'Оплата услуг';




?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div >
        <input class="insert-test" name="_csrf" type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" />
    </div>

    <div class="table-responsive table_payment payment_next_information">
        <?php
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

        include (dirname(dirname(__DIR__)) . '/components/billing_api/admin/wm.php')

        ?>
    </div>

    <p>
        <?= $payment ?>
    </p>



</div>