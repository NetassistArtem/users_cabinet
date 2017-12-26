<?php
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;
use \yii\widgets\MaskedInput;
use app\assets\AppAsset;

$this->title = Yii::t('change-phone', 'change_phone');


?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('change-phone', 'change_phone'). ' '.$phone_old ?></p>
        </div>
        <div class="panel-body">




            <?php Pjax::begin(['id' => 'phone-change']); ?>

            <div>

                <?php
                $flash_message = Yii::$app->session->getFlash('phoneDeleteChanged')['value'];
                if(isset($flash_message)):


                    $this->registerJsFile(
                        'scripts/message_with_redirect.js',
                        ['depends'=>'app\assets\AppAsset']
                    );

                    // $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
                endif;
                ?>

            </div>



    <div class="row" >
        <label class=" col-lg-4 col-md-4 col-sm-4 text-right control-label" for="old_phone_text"><?= Yii::t('upravlenie-kabinetom', 'old_phone_change') ?></label>
        <div class=" col-lg-4 col-md-4 col-sm-4 " id="old_phone_text"> <p><?= $phone_old ?></p></div>

    </div>






            <?php $form_phone_1_change = ActiveForm::begin([
                'id' => 'phoneFirstChangeForm',
                'options' => ['data-pjax' => false],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],


            ]); ?>

            <?php if(Yii::$app->session->hasFlash('phoneNotDelete')): ?>
                <div class="alert alert-danger" >
                    <p><?= Yii::$app->session->getFlash('phoneNotDelete')['value']; ?></p>
                </div>
            <?php endif; ?>

            <?= $form_phone_1_change->field($modelPhoneFirstChange, 'phone1')->label(Yii::t('upravlenie-kabinetom', 'phone_change_new'))->
            widget(\yii\widgets\MaskedInput::className(), ['mask' => '+380 (99) 999 99 99'])->input('phone', ['value' =>  $phone_old_short  ]) ?>


            <div class="form-group">


                    <div class="col-lg-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'change_phone_1'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'phone-first-change-button', 'value' => 2]) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4" id="btn-delete-phone-change">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'delete_phone_1').' '.$phone_old, ['class' => 'btn btn-primary  btn-lg btn-submit-custom', 'name' => 'phone-first-delete-button', 'value' => 1, 'onclick' => "return destroy_submit_phone($phone_old_short)"]) ?>
                    </div>
            </div>

            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>


        </div>
    </div>

</div>


