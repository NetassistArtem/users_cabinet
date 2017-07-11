<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;
use \yii\widgets\MaskedInput;

?>

<div id="success" class="view_message view_message_padding" ><?= Yii::t('call-request', 'call_you_back') ?></div>
<div class="call-request-user-form">

 <?php
$form_call_request = ActiveForm::begin([
    'id' => 'callRequestForm',
    'options' => [ 'class' => 'call-request-form'],
    'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'fieldConfig' => [
        'template' => "{label}<div class=\"col-lg-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-12 col-md-12 col-sm-12\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label modal-label'],
    ],

]);


 ?>



    <?= $form_call_request->field($modelCallRequest, 'phone')->
    label(Yii::t('call-request', 'enter_phone'))->input('phone') ?>


    <div class="form-group">
        <div class="col-lg-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-8 col-md-8 col-sm-8">
            <?= Html::submitButton(Yii::t('call-request', 'request_call'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'call-request-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
