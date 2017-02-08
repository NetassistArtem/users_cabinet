<?php

use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;
use \yii\widgets\MaskedInput;
use app\assets\AppAsset;
use app\assets\AlfaBlackAsset;
use app\assets\AlfaBlackCrtAsset;
use app\assets\AlfaGrayAsset;
use app\assets\AlfaWhiteAsset;
use app\assets\KuziaAsset;

$this->title = Yii::t('upravlenie-kabinetom','account_manage');




?>
<div class="site-about">
    <div id="password_change" ></div>
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

<!-- попап всплывающий когда телефон успешно изменен (при успешном сохранении идет ридерект на эту страницу)
-->

    <div>

        <?php
        $flash_message = Yii::$app->session->getFlash('phoneFirstChangedConfirm')['value'];

        if (isset($flash_message)):

            // $this->registerJs('$("#modal").modal("show");');
            echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);
            $this->registerJsFile(
                'scripts/message.js',
                ['depends' => 'app\assets\AppAsset']
            );
        endif;
        ?>

    </div>






    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('upravlenie-kabinetom','change_password_title') ?></p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'password-change']); ?>
            <div>



                <?php
                $flash_message = Yii::$app->session->getFlash('passwordChanged')['value'];
                if(isset($flash_message)):
                    //$this->registerJs('$("#modal").modal("show");');

                    $this->registerJsFile(
                        'scripts/message.js',
                        ['depends'=>'app\assets\AppAsset']
                    );

                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
                endif;
                ?>

            </div>

            <div class="alarm_custom">
                <p><?= Yii::$app->session->getFlash('bad_password')['value']; ?></p>
            </div>

            <?php $form_password_change = ActiveForm::begin([
                'id' => 'passwordChangeForm',
                'options' => ['data-pjax' => true],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],

            ]); ?>


            <?= $form_password_change->field($modelPasswordChange, 'oldPassword')->passwordInput()->label(Yii::t('upravlenie-kabinetom','old_password')) ?>

            <?= $form_password_change->field($modelPasswordChange, 'newPasswordRepeat')->passwordInput()->label(Yii::t('upravlenie-kabinetom','new_password')) ?>

            <?= $form_password_change->field($modelPasswordChange, 'newPassword')->passwordInput()->label(Yii::t('upravlenie-kabinetom','password_confirmation')) ?>
<div id="contact_change"></div>
            <div class="form-group">
                <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4" >
                    <?= Html::submitButton(Yii::t('upravlenie-kabinetom','change_password'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'password-change-button', 'id' =>'password-change-id', 'onclick' => 'return destroy_submit()']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>





    <div class=" panel panel-default cabinet_change_forms" >
        <div class="panel-heading">
            <p><?= Yii::t('upravlenie-kabinetom','change_contact_inf') ?></p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'contact-change']); ?>


            <?php $form_contact_change = ActiveForm::begin([
                'id' => 'contactChangeForm',
                'options' => ['data-pjax' => true],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],

            ]); ?>


            <?= $form_contact_change->field($modelContactChange, 'phone1')->label(Yii::t('upravlenie-kabinetom','phone_1'))->
            widget(\yii\widgets\MaskedInput::className(), ['mask' => '+380 (99) 999 99 99'])->input('phone',['value' =>  $user_data['phone_1']]) ?>

            <?= $form_contact_change->field($modelContactChange, 'phone2')->label(Yii::t('upravlenie-kabinetom','phone_2'))->
            widget(\yii\widgets\MaskedInput::className(), ['mask' => '+380 (99) 999 99 99'])->input('phone',['value' =>  $user_data['phone_2']]) ?>

            <?= $form_contact_change->field($modelContactChange, 'email')->label('E-mail')->input('email',['value' => $user_data['email']]) ?>
          <div id="message_type_change" ></div>
            <div class="form-group">
                <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4" >
                    <?= Html::submitButton(Yii::t('upravlenie-kabinetom','change_data'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'contact-change-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>

            <div>

                <?php
                $flash_message = Yii::$app->session->getFlash('phoneDeleteChanged')['value'];
                if(isset($flash_message)):


                    $this->registerJsFile(
                        'scripts/message.js',
                        ['depends'=>'app\assets\KuziaAsset']
                    );

                    // $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
                endif;
                ?>

            </div>









            <?php $form_select_change = ActiveForm::begin([
                'id' => 'phoneSelectChangeForm',
                'options' => ['data-pjax' => true],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],


            ]); ?>
            <?php if(Yii::$app->session->hasFlash('phoneSelectChanged')): ?>
            <div class="alert alert-danger" >
                <p>
                    <?= Yii::$app->session->getFlash('phoneSelectChanged')['value']; ?>
                </p>
            </div>
            <?php endif; ?>

            <?= $form_select_change->field($modelPhoneSelectChange, 'phones')->dropDownList($user_data['phone_all_array'], ['prompt' => Yii::t('upravlenie-kabinetom','select_phone')])->label(Yii::t('upravlenie-kabinetom','phone_1')) ?>

            <div class="form-group">
                <?php if($user_data['phone_1']):?>

                <div class="col-lg-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-4 col-md-4 col-sm-4" >
                    <?= Html::submitButton(Yii::t('upravlenie-kabinetom','change_phone_1'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'phone-change-button', 'value' => 2]) ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4" >
                    <?= Html::submitButton(Yii::t('upravlenie-kabinetom','delete_phone_1'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'phone-delete-button', 'value' => 1, 'onclick' => 'return destroy_submit_phone()']) ?>
                </div>
                    <?php else: ?>
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4" >
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom','add_phone_1'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'phone-add-button', 'value' => 3]) ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
    </div>





    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('upravlenie-kabinetom','notification_settings') ?></p>
        </div>
        <div class="panel-body">


            <?php Pjax::begin(['id' => 'message-change']); ?>
            <div>

                <?php
                $flash_message = Yii::$app->session->getFlash('messageTypeChanged')['value'];

                if(isset($flash_message)):



                   // $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
                $this->registerJsFile(
                    'scripts/message.js',
                    ['depends'=>'app\assets\AppAsset']
                );
                endif;
                ?>

            </div>






            <?php $form_message_type_change = ActiveForm::begin([
                'id' => 'messageTypeChangeForm',
                'options' => ['data-pjax' => false],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-7 col-md-7 col-sm-7\">{input}</div>\n<div class=\"col-lg-1 col-md-1 col-sm-1\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],

            ]); ?>



           <?php
          if(Yii::$app->session->has('selected_options')){
              $selected_email_message_types = Yii::$app->session->get('selected_options')['email'];
              $selected_sms_message_types = Yii::$app->session->get('selected_options')['sms'];
              Yii::$app->session->close('selected_options');
          }
           $modelMessageTypeChange->emailMessage = $selected_email_message_types;// Массив с уже активными пунктами отправки на почту
           $modelMessageTypeChange->smsMessage = $selected_sms_message_types;// Массив с уже активными пунктами отправки sms
            echo $form_message_type_change->field($modelMessageTypeChange, 'emailMessage')->label(Yii::t('upravlenie-kabinetom','mail_receiving'))->checkboxList($email_message_types) ?>


            <?= $form_message_type_change->field($modelMessageTypeChange, 'smsMessage')->label(Yii::t('upravlenie-kabinetom','receive_sms'))->checkboxList($sms_message_types); ?>



            <div class="form-group">
                <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4" >
                    <?= Html::submitButton(Yii::t('upravlenie-kabinetom','save_settings'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'message-type-change-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>


</div>