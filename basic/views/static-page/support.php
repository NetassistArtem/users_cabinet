<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;
use yii\bootstrap\Modal;


$this->title = 'Техническая поддержка';

?>
<div class="site-about">
     <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p>Форма заявки в техническую поддержку</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'technical-support']); ?>
            <div>



                <?php
                $flash_message = Yii::$app->session->getFlash('TechnicalInfo')['value'];
                if(isset($flash_message)):
                    $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
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


            <?= $form_technical_support->field($modelTechnicalSupport, 'sup_class')->dropDownList($support_data['problem-type'])->label('Характер проблемы') ?>

            <?= $form_technical_support->field($modelTechnicalSupport, 'problem_appeared')->textInput()->label('Когда началас проблема') ?>

            <?= $form_technical_support->field($modelTechnicalSupport, 'os_type')->dropDownList($operation_systems)->label('Операционная система') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'avir_present')->textInput()->label('Какой антивирус установлен') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'change_avir')->inline()->radioList([1 => 'Да', -1 => 'Нет', 0 => 'Нет данных'])->label('Устанавливали или обновляли антивирус') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'low_speed')->input('number')->label('Низкая скорость') ?>
        <div class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-8 col-md-8 col-sm-8" >Килобайт, то что показывает браузер при скачивании</div>
            <?= $form_technical_support->field($modelTechnicalSupport, 'router_present')->dropDownList($swith)->label('Есть ли роутер/свитч') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'change_pc')->inline()->radioList([1 => 'Да', -1 => 'Нет', 0 => 'Нет данных'])->label('Меняли ли компьютер') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'user_wifi_link')->inline()->radioList([1 => 'Да', -1 => 'Нет', 0 => 'Нет данных'])->label('Компьютер подключен по Wi-Fi') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'direct_link_ok')->inline()->radioList([1 => 'Да', -1 => 'Нет', 0 => 'Нет данных'])->label('Если да, то есть ли выход на наш сайт БЕЗ роутера') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'low_speed_direct')->input('number')->label('Какая скорость скачивания с film.alfa-inet.net БЕЗ роутера') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'user_reboot')->inline()->radioList([1 => 'Да', -1 => 'Нет', 0 => 'Нет данных'])->label('Перезагружали ли компьютер') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'user_wifi_reboot')->inline()->radioList([1 => 'Да', -1 => 'Нет', 0 => 'Нет данных'])->label('Перезагружали ли WiFi/роутер/свитч') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'user_wifi_wan')->inline()->radioList([1 => 'Да', -1 => 'Нет', 0 => 'Нет данных'])->label('На WiFi/роутер/свитч есть индикация WAN/Internet') ?>
            <?= $form_technical_support->field($modelTechnicalSupport, 'todo_desc')->textarea(['rows' => 5])->label('Сообщение') ?>
            <div class="col-lg-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-8 col-md-8 col-sm-8" >
                <p>Загружаемые файлы должны быть менбьше <i class="message_main_text">3 МБ</i> .</p>
                <p>Допустимые расширения файлов:</p>
                <p>изображения: <i class="message_main_text">.jpg, .png, .giff, .tiff </i></p>
                <p>текстовые документы: <i class="message_main_text">.pdf, .doc, .docs, .txt, .odt</i></p>
            </div>
            <?= $form_technical_support->field($modelTechnicalSupport, 'import_file_name')->fileInput(['class' => 'send_file_buttons', 'multiple' => true,])->label('Приложить файл') ?>


            <div class="form-group">
                <div class="col-lg-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-4 col-md-4 col-sm-4" >
                    <?= Html::submitButton('Отправить заявку', ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'technical-support-button']) ?>

                </div>
                <div class=" col-lg-4 col-md-4 col-sm-4" >
                    <?= Html::resetButton('Очистить форму', ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'technical-support-reset-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>


</div>