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

$this->title = Yii::t('renew_password', 'renew_password');


?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('renew_password', 'select_contacts_data') ?></p>
        </div>
        <div class="panel-body">

            <div class="alert alert-success">
                <p>
                    <?= Yii::t('renew_password', 'info_text'); ?>
                </p>
            </div>




            <?php Pjax::begin(['id' => 'renew-password']); ?>

            <div>

                <?php
                $flash_message = Yii::$app->session->getFlash('renewPassword')['value'];
                if(isset($flash_message)):
                    // $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
                endif;
                ?>

            </div>

            <?php if(isset($flash_message)):?>
                <div class="alert alert-danger">
                    <p>
                        <?= $flash_message; ?>
                    </p>
                </div>

            <?php endif; ?>





            <?php $form_renew_password = ActiveForm::begin([
                'id' => 'renewPasswordForm',
                'options' => ['data-pjax' => true],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],


            ]); ?>


            <?= $form_renew_password->field($modelRenewPassword, 'phone')->label(Yii::t('renew_password', 'phone'))->
            widget(\yii\widgets\MaskedInput::className(), ['mask' => '+380 (99) 999 99 99'])->input('phone') ?>
            <?= $form_renew_password->field($modelRenewPassword, 'email')->label(Yii::t('renew_password', 'email'))->input('email') ?>

            <div class="form-group">


                <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                    <?= Html::submitButton(Yii::t('renew_password', 'send'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'renew-password', 'value' => 1]) ?>
                </div>

            </div>

            <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>


        </div>
    </div>

</div>

<?php
if(isset($flash_message)):

    $this->registerJsFile(
        'scripts/message.js',
        ['depends'=>'app\assets\AppAsset']
    );

    endif;

?>



