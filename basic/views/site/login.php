<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use app\models\Lang;

$this->title = Yii::t('login','title_login');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1 class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3  login-title-position"><?= Html::encode($this->title) ?></h1>


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
        </div>

    <?php ActiveForm::end(); ?>





</div>
