<?php
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;
use app\components\debugger\Debugger;
use \yii\widgets\MaskedInput;
use app\assets\AppAsset;

$this->title = Yii::t('change-email', 'change_email');


?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('change-email', 'change_email') ?></p>
        </div>
        <div class="panel-body">




            <?php Pjax::begin(['id' => 'email-change']); ?>

            <div>

                <?php
                $flash_message = Yii::$app->session->getFlash('emailDeleteChanged')['value'];
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


            <?php $form_email_change = ActiveForm::begin([
                'id' => 'emailChangeForm',
                'options' => ['data-pjax' => false],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],


            ]); ?>

            <?php if(Yii::$app->session->hasFlash('emailNotDelete')): ?>
                <div class="alert alert-danger" >
                    <p><?= Yii::$app->session->getFlash('emailNotDelete')['value']; ?></p>
                </div>
            <?php endif; ?>


            <?= $form_email_change->field($modelEmailChange, 'email')->label(Yii::t('upravlenie-kabinetom', 'email'))->
            input('email', ['value' => Yii::$app->session->get('email_to_change')]) ?>

            <div class="form-group">


                    <div class="col-lg-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'change_email'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'email-change-button', 'value' => 2]) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4" id = "btn-delete-email-change">
                        <?= Html::submitButton(Yii::t('upravlenie-kabinetom', 'delete_email'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'email-delete-button', 'value' => 1, 'onclick' => 'return destroy_submit_phone()']) ?>
                    </div>
            </div>

            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>


        </div>
    </div>

</div>


