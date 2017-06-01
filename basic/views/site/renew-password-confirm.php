<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;

$server_name = Yii::$app->params['server_name'];
$styles =  Yii::$app->params['domains'][$server_name];

$this->title = Yii::t('renew_password', 'confirm_contact_info');


?>
<div class="site-about">


    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">

            <p><?= Yii::t('renew_password', 'renew_password_confirm_code'); ?></p>
        </div>
        <div class="panel-body">




            <div>

                <?php
                $flash_message = Yii::$app->session->getFlash('renewPassword')['value'];
                if(isset($flash_message)):
                    // $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
                endif;
                ?>

            </div>

            <?php if(isset($flash_message)):?>
                <div class="alert alert-success">
                    <p>
                        <?= Yii::t('renew_password', 'renew_pass_info_text'); ?>
                    </p>
                </div>
            <?php endif; ?>





            <?php

                $form_code_confirm = ActiveForm::begin([
                    'id' => 'renewPasswordForm',
                    'options' => ['data-pjax' => true],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],

                ]); ?>


                <?php if(Yii::$app->session->hasFlash('codeConfirm')): ?>
                <div class="alert alert-danger" >
                    <p><?= Yii::$app->session->getFlash('codeConfirm')['value']; ?></p>
                </div>
                <?php endif; ?>









                <?= $form_code_confirm->field($modelRenewPasswordConfirm, 'confirmcode')->label(Yii::t('renew_password', 'verification_code'))->textInput(['size' => 10]) ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('renew_password', 'send_code'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'renew-password-confirm-button']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="btn btn-block btn-lg btn-custom">
                        <a href="/<?= $lang . "/renew-password-confirm?".$contact_type."=1" ?>"><?= Yii::t('renew_password', 'resend_code'); ?></a>
                    </div>
                </div>



                <?php ActiveForm::end(); ?>







        </div>
    </div>


</div>

