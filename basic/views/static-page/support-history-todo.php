<?php

use yii\helpers\Html;
use app\components\debugger\Debugger;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;


$this->title = Yii::t('support_history', 'request') . $todo_id;

?>
<div class="site-about">

    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 todo-custom-view">
        <?= $todo_history_node ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class=" panel panel-default cabinet_change_forms">
            <div class="panel-heading">
                <p><?= Yii::t('support_history', 'answer') ?></p>
            </div>

            <div class="panel-body">

                <div>

                    <?php
                    $flash_message = Yii::$app->session->getFlash('feedback')['value'];
                    if (isset($flash_message)):


                        $this->registerJs('$("#modal").modal("show");');
                        echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);


                    endif;
                    ?>

                </div>

                <?php $form_updateTodo = ActiveForm::begin([
                    'id' => 'updateTodoForm',
                    'options' => ['data-pjax' => false, 'enctype' => 'multipart/form-data'],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-6 col-md-6 col-sm-6 message-history-support\">{input}</div>\n<div class=\"col-lg-3 col-md-3 col-sm-3 message-history-support\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-3 control-label message-history-support'],
                    ],

                ]); ?>


                <?= $form_updateTodo->field($modelUpdateTodo, 'todo_desc')->textarea(['rows' => 5])->label(Yii::t('feedback', 'message_text')) ?>

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
                    <p><?= Yii::t('feedback', 'images') ?> <i class="message_main_text">.jpg, .png, .giff, .tiff </i>
                    </p>
                    <p><?= Yii::t('feedback', 'text_documents') ?> <i class="message_main_text">.pdf, .doc, .docs, .txt,
                            .odt</i></p>
                </div>
                <?= $form_updateTodo->field($modelUpdateTodo, 'files[]')->fileInput(['class' => 'send_file_buttons', 'multiple' => true,])->label('Прикрепить файл') ?>

                <div class='hiden-fields'>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'y1')->hiddenInput(['value' => Yii::$app->formatter->asDate('now', 'Y')])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'm1')->hiddenInput(['value' => Yii::$app->formatter->asDate('now', 'M')])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'd1')->hiddenInput(['value' => Yii::$app->formatter->asDate('now', 'd')])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'h1')->hiddenInput(['value' => Yii::$app->formatter->asDatetime('now', 'H')])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'mn1')->hiddenInput(['value' => Yii::$app->formatter->asDatetime('now', 'm')])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'exec_list')->hiddenInput(['value' => '@duty', 'class' => 'hiden-fields'])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'sv_list')->hiddenInput(['value' => '@support-lan,@duty'])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'rsp_admin_id')->hiddenInput(['value' => $todo_history['rsp_admin_id'], 'class' => 'hiden-fields'])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'severity')->hiddenInput(['value' => $todo_history['severity']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'subj')->hiddenInput(['value' => iconv_safe('koi8-u', 'utf-8', $todo_history['subj'])])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'user_net_id')->hiddenInput(['value' => $todo_history['user_net_id']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'todo_type')->hiddenInput(['value' => $todo_history['todo_type']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'ref_acc_id')->hiddenInput(['value' => $todo_history['ref_acc_id']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'orig_ref_acc_id')->hiddenInput(['value' => $todo_history['orig_ref_acc_id']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'orig_todo_state')->hiddenInput(['value' => $todo_history['orig_todo_state']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'ref_req_id')->hiddenInput(['value' => $todo_history['ref_req_id']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'orig_origin_todo_id')->hiddenInput(['value' => $todo_history['orig_origin_todo_id']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'origin_todo_id')->hiddenInput(['value' => $todo_history['origin_todo_id']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'ref_loc_id')->hiddenInput(['value' => $todo_history['ref_loc_id']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'call_support')->hiddenInput(['value' => 1])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'user_name')->hiddenInput(['value' => $todo_history['user_name']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'sub_todo_id')->hiddenInput(['value' => ''])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'last_ver')->hiddenInput(['value' => $todo_history['todo_ver'] + 1])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'orig_admin_id')->hiddenInput(['value' => $todo_history['orig_admin_id']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'orig_hide_mask')->hiddenInput(['value' => $todo_history['orig_hide_mask']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'hw_fault_hash_orig')->hiddenInput(['value' => $todo_history['hw_fault_hash']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'night_work0')->hiddenInput(['value' => ''])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'complexity0')->hiddenInput(['value' => ''])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'edit_req')->hiddenInput(['value' => 1])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'todo_id')->hiddenInput(['value' => $todo_history['todo_id']])->label(false); ?>
                    <?= $form_updateTodo->field($modelUpdateTodo, 'next_serial')->hiddenInput(['value' => ''])->label(false); ?>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-6 col-md-6 col-sm-6">
                        <?= Html::submitButton(Yii::t('support_history', 'send_message'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'feedback-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>


</div>