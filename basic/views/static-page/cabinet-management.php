<?php

use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;
use \yii\widgets\MaskedInput;




$this->title = Yii::t('upravlenie-kabinetom', 'account_manage');


?>
<div class="site-about">
    <div id="password_change"></div>
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

        endif;
        ?>

    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('upravlenie-kabinetom', 'change_password_title') ?></p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'password-change']); ?>
            <div>


                <?php
                $flash_message = Yii::$app->session->getFlash('passwordChanged')['value'];

                if (isset($flash_message)):
                    //$this->registerJs('$("#modal").modal("show");');
                  //  Debugger::EhoBr($flash_message);


                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);
                endif;
                ?>

            </div>

            <div class="alarm_custom">
                <p><?= Yii::$app->session->getFlash('bad_password')['value']; ?></p>
            </div>

            <?php $form_password_change = ActiveForm::begin([
                'id' => 'passwordChangeForm',
                'options' => ['data-pjax' => false],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],

            ]); ?>


            <?= $form_password_change->field($modelPasswordChange, 'oldPassword')->passwordInput()->label(Yii::t('upravlenie-kabinetom', 'old_password')) ?>

            <?= $form_password_change->field($modelPasswordChange, 'newPasswordRepeat')->passwordInput()->label(Yii::t('upravlenie-kabinetom', 'new_password')) ?>

            <?= $form_password_change->field($modelPasswordChange, 'newPassword')->passwordInput()->label(Yii::t('upravlenie-kabinetom', 'password_confirmation')) ?>
            <div id="contact_change"></div>
            <div class="form-group">
                <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                    <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'change_password'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'password-change-button', 'id' => 'password-change-id', 'onclick' => 'return destroy_submit()']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('upravlenie-kabinetom', 'change_contact_inf') ?></p>
        </div>
        <div class="panel-body">
            <div class="change-contacts-section">
                <div class="change-contacts-title">
                    <p><?= Yii::t('upravlenie-kabinetom', 'change_2_phone') ?></p>
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
                <?php if (Yii::$app->session->hasFlash('phoneSelectChanged')): ?>
                    <div class="alert alert-danger">
                        <p>
                            <?= Yii::$app->session->getFlash('phoneSelectChanged')['value']; ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?= $form_select_change->field($modelPhoneSelectChange, 'phones')->dropDownList($user_data['phone_all_array'], ['prompt' => Yii::t('upravlenie-kabinetom', 'select_phone')])->label(Yii::t('upravlenie-kabinetom', 'phone_1')) ?>

                <div class="form-group">


                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'change_phone_1'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'phone-change-button', 'value' => 2]) ?>
                    </div>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
            <div class="change-contacts-section">
                <div class="change-contacts-title">
                    <p><?= Yii::t('upravlenie-kabinetom', 'add_new_phone') ?></p>
                </div>
                <?php $form_add_phone = ActiveForm::begin([
                    'id' => 'phoneAddForm',
                    'options' => ['data-pjax' => true],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],


                ]); ?>
                <?php if (Yii::$app->session->hasFlash('phoneAdd')): ?>
                    <div class="alert alert-danger">
                        <p>
                            <?= Yii::$app->session->getFlash('phoneAdd')['value']; ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?= $form_add_phone->field($modelPhoneAddForm, 'phone1')->label(Yii::t('upravlenie-kabinetom', 'phone'))->
                widget(\yii\widgets\MaskedInput::className(), ['mask' => '+380 (99) 999 99 99'])->input('phone') ?>

                <div class="form-group">


                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'add_phone_1'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'phone-change-button', 'value' => 2]) ?>
                    </div>

                </div>

                <?php ActiveForm::end(); ?>

            </div>


            <div class="change-contacts-section">
                <div class="change-contacts-title">
                    <p><?= Yii::t('upravlenie-kabinetom', 'change_2_email') ?></p>
                </div>
                <?php $form_email_select = ActiveForm::begin([
                    'id' => 'emailSelectChangeForm',
                    'options' => ['data-pjax' => true],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],


                ]); ?>
                <?php if (Yii::$app->session->hasFlash('emailSelectChanged')): ?>
                    <div class="alert alert-danger">
                        <p>
                            <?= Yii::$app->session->getFlash('emailSelectChanged')['value']; ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?= $form_email_select->field($modelEmailSelectChange, 'emails')->dropDownList($user_data['email_array'], ['prompt' => Yii::t('upravlenie-kabinetom', 'select_email')])->label(Yii::t('upravlenie-kabinetom', 'email')) ?>

                <div class="form-group">


                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'change_email'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'email-change-button', 'value' => 2]) ?>
                    </div>

                </div>


                <?php ActiveForm::end(); ?>

            </div>
            <div class="change-contacts-section">
                <div class="change-contacts-title">
                    <p><?= Yii::t('upravlenie-kabinetom', 'add_new_email') ?></p>
                </div>
                <?php $form_add_email = ActiveForm::begin([
                    'id' => 'emailAddForm',
                    'options' => ['data-pjax' => true],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],


                ]); ?>
                <?php if (Yii::$app->session->hasFlash('emailAdd')): ?>
                    <div class="alert alert-danger">
                        <p>
                            <?= Yii::$app->session->getFlash('emailAdd')['value']; ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?= $form_add_email->field($modelEmailAddForm, 'email')->label(Yii::t('upravlenie-kabinetom', 'email'))->input('email') ?>

                <div class="form-group">


                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'add_email'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'email-change-button', 'value' => 2]) ?>
                    </div>

                </div>

                <?php ActiveForm::end(); ?>


            </div>


        </div>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('upravlenie-kabinetom', 'notification_settings') ?></p>
        </div>
        <div class="panel-body">


            <?php Pjax::begin(['id' => 'message-change']); ?>
            <div>

                <?php
                $flash_message = Yii::$app->session->getFlash('messageTypeChanged')['value'];

                if (isset($flash_message)):


                    // $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);

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
            if (Yii::$app->session->has('selected_options')) {
                $selected_email_message_types = Yii::$app->session->get('selected_options')['email'];
                $selected_sms_message_types = Yii::$app->session->get('selected_options')['sms'];
                Yii::$app->session->close('selected_options');
            }
            $modelMessageTypeChange->emailMessage = $selected_email_message_types;// Массив с уже активными пунктами отправки на почту
            $modelMessageTypeChange->smsMessage = $selected_sms_message_types;// Массив с уже активными пунктами отправки sms
            echo $form_message_type_change->field($modelMessageTypeChange, 'emailMessage')->label(Yii::t('upravlenie-kabinetom', 'mail_receiving'))->checkboxList($email_message_types) ?>


            <?= $form_message_type_change->field($modelMessageTypeChange, 'smsMessage')->label(Yii::t('upravlenie-kabinetom', 'receive_sms'))->checkboxList($sms_message_types); ?>


            <div class="form-group">
                <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                    <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'save_settings'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'message-type-change-button']) ?>
                </div>
                <div id="services_change"></div>
            </div>

            <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>

        </div>

    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('upravlenie-kabinetom', 'services_change') ?></p>
        </div>
        <div class="panel-body">


            <?php if (Yii::$app->session->hasFlash('servicesChangedPauseInformation')): ?>
                <div class="alert alert-success">
                    <p>
                        <?= Yii::$app->session->getFlash('servicesChangedPauseInformation')['value']; ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if (!empty($active_services_array)): ?>

                <?php Pjax::begin(['id' => 'services-change-pause-start']); ?>
                <div>

                    <?php
                    $flash_message_2 = Yii::$app->session->getFlash('servicesChangedPause')['value'];

                    if (isset($flash_message_2)):


                        // $this->registerJs('$("#modal").modal("show");');
                        echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);

                    endif;
                    ?>

                </div>
                <?php if (!empty($paused_services_array)): ?>
                    <div class="change-contacts-section">
                <?php endif; ?>
                <div class="change-contacts-title">
                    <p><?= Yii::t('upravlenie-kabinetom', 'pause_start_title') ?></p>
                </div>

                <?php $form_services_change_pause_start = ActiveForm::begin([
                    'id' => 'servicesChangePauseStartForm',
                    'options' => ['data-pjax' => true],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],


                ]); ?>

                <?= $form_services_change_pause_start->field($modelServicesChangePauseStart, 'services')->label(Yii::t('upravlenie-kabinetom', 'services_selected'))->dropDownList($active_services_array, ['prompt' => Yii::t('upravlenie-kabinetom', 'select_services')]) ?>
                <?= $form_services_change_pause_start->field($modelServicesChangePauseStart, 'from_date')->label(Yii::t('upravlenie-kabinetom', 'pause_start_date'))->input('date', ['value' => Yii::$app->formatter->asDate('now', 'yyyy-MM-dd'), 'min' => Yii::$app->formatter->asDate('now', 'yyyy-MM-dd')]) ?>

                <div class="form-group">


                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'start_pause'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'services-pause-start-button', 'value' => 1]) ?>
                    </div>

                </div>


                <?php ActiveForm::end(); ?>
                <?php if (!empty($paused_services_array)): ?>
                    </div>
                <?php endif; ?>
                <?php Pjax::end();
            endif;
            ?>




            <?php if (!empty($paused_services_array)): ?>
                <?php Pjax::begin(['id' => 'services-change-pause-finish']); ?>
                <div>

                    <?php
                    $flash_message_2 = Yii::$app->session->getFlash('servicesChangedPause')['value'];

                    if (isset($flash_message_2)):


                        // $this->registerJs('$("#modal").modal("show");');
                        echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);

                    endif;
                    ?>

                </div>

                <?php if (!empty($active_services_array)): ?>
                    <div class="change-contacts-section">
                <?php endif; ?>
                <div class="change-contacts-title">
                    <p><?= Yii::t('upravlenie-kabinetom', 'pause_finish_title') ?></p>
                </div>


                <?php $form_services_change_pause_finish = ActiveForm::begin([
                    'id' => 'servicesChangePauseFinishForm',
                    'options' => ['data-pjax' => true],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],


                ]); ?>

                <?= $form_services_change_pause_finish->field($modelServicesChangePauseFinish, 'services')->label(Yii::t('upravlenie-kabinetom', 'services_selected'))->dropDownList($paused_services_array, ['prompt' => Yii::t('upravlenie-kabinetom', 'select_services')]) ?>

                <div class="form-group">


                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'renew'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'services-pause-finish-button', 'value' => 1]) ?>
                    </div>

                </div>


                <?php ActiveForm::end(); ?>
                <?php if (!empty($active_services_array)): ?>
                    </div>
                <?php endif; ?>
                <?php Pjax::end();
            endif;

            if (empty($paused_services_array) && empty($active_services_array)):
                ?>
                <div class="alert alert-success">
                    <p>
                        <?= Yii::t('upravlenie-kabinetom', 'no_data_to_change'); ?>
                    </p>
                </div>
            <?php endif; ?>


        </div>
    </div>

    <?php if ($user_data['org_id'] != 7): ?>
        <div class=" panel panel-default cabinet_change_forms">
            <div class="panel-heading">
                <p><?= Yii::t('upravlenie-kabinetom', 'skin_change') ?></p>
            </div>
            <div class="panel-body">


                <?php Pjax::begin(['id' => 'skin-change']); ?>
                <div>

                    <?php
                    $flash_message = Yii::$app->session->getFlash('messageSkinChanged')['value'];

                    if (isset($flash_message)):


                        // $this->registerJs('$("#modal").modal("show");');
                        echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);

                    endif;
                    ?>

                </div>


                <?php $form_skin_change = ActiveForm::begin([
                    'id' => 'skinChangedForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-7 col-md-7 col-sm-7\">{input}</div>\n<div class=\"col-lg-1 col-md-1 col-sm-1\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],

                ]); ?>



                <?php
                echo '';
                /*
                if (Yii::$app->session->has('selected_options')) {
                    $selected_email_message_types = Yii::$app->session->get('selected_options')['email'];
                    $selected_sms_message_types = Yii::$app->session->get('selected_options')['sms'];
                    Yii::$app->session->close('selected_options');
                }
                $modelMessageTypeChange->emailMessage = $selected_email_message_types;// Массив с уже активными пунктами отправки на почту
                $modelMessageTypeChange->smsMessage = $selected_sms_message_types;// Массив с уже активными пунктами отправки sms
                echo $form_message_type_change->field($modelMessageTypeChange, 'emailMessage')->label(Yii::t('upravlenie-kabinetom', 'mail_receiving'))->checkboxList($email_message_types) */ ?>


                <?= $form_skin_change->field($modelSkinsChange, 'skin')->label(Yii::t('upravlenie-kabinetom', 'skins'))->radioList($skin_types, ['value' => $selected_skin_type]); ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'save_skin'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'skin-change-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

                <?php Pjax::end(); ?>


            </div>
        </div>
    <?php endif; ?>


</div>






