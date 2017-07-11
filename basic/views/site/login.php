<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use app\assets\AppAsset;
use app\models\Lang;

$this->title = Yii::t('login','title_login');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-2 col-lg-12 col-md-12 col-sm-12 col-xs-8">
    <h1 class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3  login-title-position"><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['id' => 'login-page']); ?>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3 col-md-3 col-sm-3\">{input}</div>\n<div class=\"col-lg-5 col-md-5 col-sm-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->textInput()->hint('Пожалуйста, введите № договора')->label(Yii::t('login','login')) ?>

        <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('login','password')) ?>


        <div class="form-group">
            <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-lg-3 col-md-3 col-sm-3">
                <?= Html::submitButton(Yii::t('login','enter'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'login-button']) ?>
            </div>
            <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-lg-3 col-md-3 col-sm-3" >
                <a class="btn btn-primary btn-block btn-lg btn-submit-custom" href="/<?=$lang ?>/renew-password"><?= Yii::t('login', 'renew-password') ?></a>
            </div>

        </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>

<div>

    <?php
    $flash_message = Yii::$app->session->getFlash('renewPassword')['value'];
    if(isset($flash_message)):


        // $this->registerJs('$("#modal").modal("show");');
        echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php',['flash_message' => $flash_message]);
    endif;
    ?>

</div>
