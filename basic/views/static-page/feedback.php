<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;
use yii\bootstrap\Modal;

$this->title = Yii::t('feedback', 'feedback');

?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('feedback', 'feedback_panel') ?></p>
        </div>
        <div class="panel-body">

            <div>

                <?php
                $flash_message = Yii::$app->session->getFlash('feedback')['value'];
                if (isset($flash_message)):


                    $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);
                    $this->registerJsFile(
                        'scripts/message.js',
                        ['depends' => 'app\assets\AppAsset']
                    );

                endif;
                ?>

            </div>

            <?php $form_feedback = ActiveForm::begin([
                'id' => 'feedbackForm',
                'options' => ['data-pjax' => false, 'enctype' => 'multipart/form-data'],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-6 col-md-6 col-sm-6\">{input}</div>\n<div class=\"col-lg-3 col-md-3 col-sm-3\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-3 control-label'],
                ],

            ]);


            ?>



            <?= $form_feedback->field($modelFeedback, 'todo_desc')->textarea(['rows' => 5])->label(Yii::t('feedback', 'message_text')) ?>

            <!--    <div class="form-group file_upload">

                    <div  class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-4 col-md-4 col-sm-4" >
                        <button type="button">Выбрать</button>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5" >
                        <p>Файл не выбран</p>
                    </div>

                </div> -->

            <div class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-8 col-md-8 col-sm-8">
                <p><?= Yii::t('feedback', 'less_than') ?> <i
                        class="message_main_text">3 <?= Yii::t('feedback', 'mb') ?></i>.</p>
                <p><?= Yii::t('feedback', 'file_extensions') ?></p>
                <p><?= Yii::t('feedback', 'images') ?> <i class="message_main_text">.jpg, .png, .giff, .tiff </i></p>
                <p><?= Yii::t('feedback', 'text_documents') ?> <i class="message_main_text">.pdf, .doc, .docs, .txt,
                        .odt</i></p>
            </div>
            <?= $form_feedback->field($modelFeedback, 'files[]')->fileInput(['multiple'=>true,'class' => 'send_file_buttons'])->label(Yii::t('feedback', 'attach_file')) ?>
            <div class="hiden-fields">
                <?= $form_feedback->field($modelFeedback, 'y1')->hiddenInput(['value' => Yii::$app->formatter->asDate('now', 'Y')])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'm1')->hiddenInput(['value' => Yii::$app->formatter->asDate('now', 'M')])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'd1')->hiddenInput(['value' => Yii::$app->formatter->asDate('now', 'd')])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'h1')->hiddenInput(['value' => Yii::$app->formatter->asDatetime('now', 'H')])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'mn1')->hiddenInput(['value' => Yii::$app->formatter->asDatetime('now', 'm')])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'exec_list')->hiddenInput(['value' => '@duty', 'class' => 'hiden-fields'])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'sv_list')->hiddenInput(['value' => '@support-lan,@duty'])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'rsp_admin_id')->hiddenInput(['value' => 0, 'class' => 'hiden-fields'])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'severity')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'subj')->hiddenInput(['value' => 'Отзыв - ' . $user_data['username'] . ' , ' . $user_data['address']])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'user_net_id')->hiddenInput(['value' => $user_data['net_id']])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'todo_type')->hiddenInput(['value' => 3])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'ref_acc_id')->hiddenInput(['value' => $user_data['account_id']])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'orig_ref_acc_id')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'orig_todo_state')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'ref_req_id')->hiddenInput(['value' => -1])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'orig_origin_todo_id')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'origin_todo_id')->hiddenInput(['value' => -1])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'ref_loc_id')->hiddenInput(['value' => $user_data['address_id']])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'call_support')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'user_name')->hiddenInput(['value' => $user_data['username']])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'sub_todo_id')->hiddenInput(['value' => 0])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'last_ver')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'orig_admin_id')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'orig_hide_mask')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'hw_fault_hash_orig')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'night_work0')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'complexity0')->hiddenInput(['value' => ''])->label(false); ?>
                <?= $form_feedback->field($modelFeedback, 'next_serial')->hiddenInput(['value' => ''])->label(false); ?>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-6 col-md-6 col-sm-6">
                    <?= Html::submitButton(Yii::t('feedback', 'send_feedback'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'feedback-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
    </div>


</div>