<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;
use yii\bootstrap\Modal;

$this->title = 'Оставить отзыв';

?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p>Отзыв</p>
        </div>
        <div class="panel-body">

            <div>

                    <?php
                    $flash_message = Yii::$app->session->getFlash('feedback')['value'];
                    if(isset($flash_message)):



                        $this->registerJs('$("#modal").modal("show");');
                   echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
                        $this->registerJsFile(
                            'scripts/message.js',
                            ['depends'=>'app\assets\AppAsset']
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

            ]); ?>



            <?= $form_feedback->field($modelFeedback, 'message')->textarea(['rows' => 5])->label('Текст сообщения') ?>

        <!--    <div class="form-group file_upload">

                <div  class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-4 col-md-4 col-sm-4" >
                    <button type="button">Выбрать</button>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5" >
                    <p>Файл не выбран</p>
                </div>

            </div> -->

            <div class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-8 col-md-8 col-sm-8" >
                <p>Загружаемые файлы должны быть менбьше <i class="message_main_text">3 МБ</i> .</p>
                <p>Допустимые расширения файлов:</p>
                <p>изображения: <i class="message_main_text">.jpg, .png, .giff, .tiff </i></p>
                <p>текстовые документы: <i class="message_main_text">.pdf, .doc, .docs, .txt, .odt</i></p>
            </div>
            <?= $form_feedback->field($modelFeedback, 'files[]')->fileInput(['class' => 'send_file_buttons', 'multiple' => true,])->label('Прикрепить файл') ?>

            <div class="form-group">
                <div class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-6 col-md-6 col-sm-6">
                    <?= Html::submitButton('Отправить отзыв', ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'feedback-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
    </div>


</div>