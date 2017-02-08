<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;
use yii\bootstrap\Modal;


$this->title = Yii::t('support','technical_support');

?>
<div class="site-about">
     <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('support','appl_form_support') ?></p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'technical-support']); ?>
            <div>



                <?php
                $flash_message = Yii::$app->session->getFlash('TechnicalInfo')['value'];
                if(isset($flash_message)):
                    $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
                    $this->registerJsFile(
                        'scripts/message.js',
                        ['depends' => 'app\assets\AppAsset']
                    );

                endif;
                ?>

            </div>

            <?php $form_technical_support = ActiveForm::begin([
                'id' => 'TechnicalSupportForm',
                'options' => ['data-pjax' => true],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],

            ]); ?>


            <?= $form_technical_support->field($modelTechnicalSupport, 'sup_class')->dropDownList($support_data['problem-type'])->label(Yii::t('support','problem_type')) ?>

            <?= $form_technical_support->field($modelTechnicalSupport, 'problem_appeared')->textInput()->label(Yii::t('support','when_problem')) ?>

            <?= $form_technical_support->field($modelTechnicalSupport, 'os_type')->dropDownList($operation_systems)->label(Yii::t('support','operating_system')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'avir_present')->textInput()->label(Yii::t('support','which_antivirus')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'change_avir')->inline()->radioList([1 => Yii::t('support','yes'), -1 => Yii::t('support','no'), 0 => Yii::t('support','unknown')])->label(Yii::t('support','install_update_anti-virus')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'low_speed')->input('number')->label(Yii::t('support','low_speed')) ?>
        <div class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-8 col-md-8 col-sm-8" ><?=Yii::t('support','kilobyte_downloading') ?></div>
            <?= $form_technical_support->field($modelTechnicalSupport, 'router_present')->dropDownList($swith)->label(Yii::t('support','is_there_switch')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'change_pc')->inline()->radioList([1 => Yii::t('support','yes'), -1 => Yii::t('support','no'), 0 => Yii::t('support','unknown')])->label(Yii::t('support','new_computer')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'user_wifi_link')->inline()->radioList([1 => Yii::t('support','yes'), -1 => Yii::t('support','no'), 0 => Yii::t('support','unknown')])->label(Yii::t('support','computer_wifi_connected')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'direct_link_ok')->inline()->radioList([1 => Yii::t('support','yes'), -1 => Yii::t('support','no'), 0 => Yii::t('support','unknown')])->label(Yii::t('support','connection_our_website_without_router')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'low_speed_direct')->input('number')->label(Yii::t('support','download_speed_without_router')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'user_reboot')->inline()->radioList([1 => Yii::t('support','yes'), -1 => Yii::t('support','no'), 0 => Yii::t('support','unknown')])->label(Yii::t('support','restarting_computer')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'user_wifi_reboot')->inline()->radioList([1 => Yii::t('support','yes'), -1 => Yii::t('support','no'), 0 => Yii::t('support','unknown')])->label(Yii::t('support','restarting_wifi_router')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'user_wifi_wan')->inline()->radioList([1 => Yii::t('support','yes'), -1 => Yii::t('support','no'), 0 => Yii::t('support','unknown')])->label(Yii::t('support','wifi_route_indication')) ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'todo_desc')->textarea(['rows' => 5])->label(Yii::t('support','message')) ?>
            <div class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-8 col-md-8 col-sm-8" >
                <p><?= Yii::t('feedback', 'less_than') ?> <i
                        class="message_main_text">3 <?= Yii::t('feedback', 'mb') ?></i>.</p>
                <p><?= Yii::t('feedback', 'file_extensions') ?></p>
                <p><?= Yii::t('feedback', 'images') ?> <i class="message_main_text">.jpg, .png, .giff, .tiff </i></p>
                <p><?= Yii::t('feedback', 'text_documents') ?> <i class="message_main_text">.pdf, .doc, .docs, .txt,
                        .odt</i></p>
            </div>
            <?= $form_technical_support->field($modelTechnicalSupport, 'import_file_name')->fileInput(['class' => 'send_file_buttons', 'multiple' => true,])->label(Yii::t('feedback', 'attach_file')) ?>
            <div class="hiden-fields">
                <?= $form_technical_support->field($modelTechnicalSupport, 'y1')->hiddenInput(['value' => Yii::$app->formatter->asDate('now', 'Y')])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'm1')->hiddenInput(['value' => Yii::$app->formatter->asDate('now', 'M')])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'd1')->hiddenInput(['value' => Yii::$app->formatter->asDate('now', 'd')])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'h1')->hiddenInput(['value' => Yii::$app->formatter->asDatetime('now', 'H')])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'mn1')->hiddenInput(['value' => Yii::$app->formatter->asDatetime('now', 'm')])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'exec_list')->hiddenInput(['value' => '@duty', 'class' => 'hiden-fields'])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'sv_list')->hiddenInput(['value' => '@support-lan,@duty'])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'rsp_admin_id')->hiddenInput(['value' => 0, 'class' => 'hiden-fields'])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'severity')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'subj')->hiddenInput(['value' => 'В техподдержку - user ' . $user_data['username'] . ' , ' . $user_data['address']])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'user_net_id')->hiddenInput(['value' => $user_data['net_id']])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'todo_type')->hiddenInput(['value' => 12])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'ref_acc_id')->hiddenInput(['value' => $user_data['account_id']])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'orig_ref_acc_id')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'orig_todo_state')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'ref_req_id')->hiddenInput(['value' => -1])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'orig_origin_todo_id')->hiddenInput(['value' => -1])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'origin_todo_id')->hiddenInput(['value' => -1])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'ref_loc_id')->hiddenInput(['value' => $user_data['address_id']])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'call_support')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'user_name')->hiddenInput(['value' => $user_data['username']])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'sub_todo_id')->hiddenInput(['value' => 0])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'last_ver')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'orig_admin_id')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'orig_hide_mask')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'hw_fault_hash_orig')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'night_work0')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'complexity0')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_technical_support->field($modelTechnicalSupport, 'next_serial')->hiddenInput(['value' => ''])->label(false); ?>
            </div>

            <div class="form-group">
                <div class="col-lg-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-4 col-md-4 col-sm-4" >
                    <?= Html::submitButton(Yii::t('support','send_request'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'technical-support-button']) ?>

                </div>
                <div id="tehnical-support-reset-btn" class=" col-lg-4 col-md-4 col-sm-4" >
                    <?= Html::resetButton(Yii::t('support','clear_form'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'technical-support-reset-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>


</div>