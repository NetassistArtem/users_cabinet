<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;

$server_name = Yii::$app->params['server_name'];
$styles =  Yii::$app->params['domains'][$server_name];

$this->title = Yii::t('contacts-change-confirm', 'confirm_contact_info');


?>
<div class="site-about">


    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <?php


            switch ($contact_type) {
                case 'phone_1':
                    $title_text = Yii::t('contacts-change-confirm', 'change_phone_1');
                    $text_info = Yii::t('contacts-change-confirm', 'info_text_1_ph');
                    break;
                case 'phone_2':
                    $title_text = Yii::t('contacts-change-confirm', 'change_phone_2');
                    $text_info = Yii::t('contacts-change-confirm', 'info_text_1_ph');
                    break;
                case 'email':
                    $title_text = Yii::t('contacts-change-confirm', 'change_email');
                    $text_info = Yii::t('contacts-change-confirm', 'info_text_1_em');
                    break;
                default:
                    $title_text = '';
                    $text_info = '';
            }

            ?>

            <p><?= $title_text; ?></p>
        </div>
        <div class="panel-body">





            <?php

            if (Yii::$app->session->has('new_user_phone_or_email') && !empty(Yii::$app->session->get('new_user_phone_or_email')) && Yii::$app->session->has('confirmcode')):


                $form_code_confirm = ActiveForm::begin([
                    'id' => 'emailChangeConfirmForm',
                    'options' => ['data-pjax' => true],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],

                ]); ?>

                <div class=text-center>
                    <p><?= $text_info ?></p>
                    <p><?= Yii::t('contacts-change-confirm', 'info_text_2') ?></p>
                </div>
                <?php if(Yii::$app->session->hasFlash('codeConfirm')): ?>
                <div class="alert alert-danger" >
                    <p><?= Yii::$app->session->getFlash('codeConfirm')['value']; ?></p>
                </div>
                <?php endif; ?>

<?php Debugger::PrintR($_SESSION);

                echo '</br>';
                echo '</br>';
                echo '</br>';
                echo '</br>';
                echo '</br>';
                echo '</br>';
                echo $modelEmailChangeConfirm->confirmcode;
                ?>






                <?= $form_code_confirm->field($modelEmailChangeConfirm, 'confirmcode')->label(Yii::t('contacts-change-confirm', 'verification_code'))->textInput(['size' => 10]) ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('contacts-change-confirm', 'send_code'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'message-type-change-button']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="btn btn-block btn-lg btn-custom">
                        <a href="/<?= $lang ?>/email-change-confirm?sms=1"><?= Yii::t('contacts-change-confirm', 'resend_email') ?></a>
                    </div>
                </div>



                <?php ActiveForm::end(); ?>

<?php
              //  Debugger::PrintR($_POST);
              //  Debugger::PrintR($_SESSION);
              //  Debugger::VarDamp(Yii::$app->request->post('PhoneFirstChangeForm')['phone1']);
              //  Debugger::VarDamp(empty(Yii::$app->request->post('PhoneFirstChangeForm')['phone1']));
                //Debugger::testDie();
                ?>

            <?php elseif ((Yii::$app->session->has('new_user_phone_or_email') && empty(Yii::$app->session->get('new_user_phone_or_email')) && Yii::$app->session->has('confirmcode'))): ?>

                <div class=text-center>
                    <p><?=Yii::t('contacts-change-confirm', 'information_not_change') ?></p>
                    <p><?=Yii::t('contacts-change-confirm', 'fill_fields') ?></p>
                    <div class="form-group">
                        <div class="btn btn-block btn-lg btn-custom">
                            <a href="/<?= $lang ?>/upravlenie-kabinetom#contact_change"><?= Yii::t('contacts-change-confirm', 'return_upravlenie-kabinetom') ?></a>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </div>


</div>