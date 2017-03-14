<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;


$this->title = Yii::t('bank', 'bank_title');


?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('bank', 'bank_data') ?></p>
        </div>
        <div class="panel-body">
            <div class="change-contacts-section">
                <p>Отримувач платежу ТОВ "НЕТАСІСТ"</p>
                <p>р/р 26006000189101</p>
                <p>ідентифікаційний код отримувача 39481498 </p>
                <p></br></p>
                <p>Установа банку ПАТ "АКБ "КОНКОРД"</p>
                <p>Код установи банку 307350</p>
                <p></br></p>
                <p>Платник: <?= $user_data['fio'] ?>, <?= $user_data['address'] ?>
                    , <?= $user_data['phone_all_array'][1] ?></p>
                <p></br></p>
                <p>Призначення платежу <i class="red"><?= $user_data['pin'] ?></i> послуги і-нет <i class="red"><?= $user_data['username'] ?></i></p>
                <p>Сума --</p>
            </div>
            <div class="alert alert-success">
                <p>
                    <?= Yii::t('bank', 'info_1'); ?>
                </p>
                <p>
                    <?= Yii::t('bank', 'info_2'); ?>
                </p>
            </div>
        </div>
    </div>
<!--
    <div class="table-responsive">
        <table class="table table-bordered  table-border-custom">
            <thead>
            <tr>
                <th><?= '';//Yii::t('bank', 'rtf_fore_print') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>

                <td><?= '';//Yii::t('bank', 'pay_fore_month') ?></td>

            </tr>

            <tr>

                <td class="btn-custom"><a href="#"><?= ''//Yii::t('bank', 'download') ?></a></td>

            </tr>

            </tbody>
        </table>
    </div>

    !-->


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('bank', 'rtf_fore_print') ?></p>
        </div>
        <div class="panel-body">


            <?php echo '';//Pjax::begin(['id' => 'rtf_print']); ?>

            <?php $rtf_print = ActiveForm::begin([
                'id' => 'rtfPrintForm',
                'options' => ['data-pjax' => false],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],


            ]); ?>


            <?= $rtf_print->field($modelRtfPrint, 'many')->label(Yii::t('bank', 'pay_amount'))->input('number', ['min' => 1]) ?>

            <div class="form-group">


                <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                    <?= Html::submitButton(Yii::t('bank', 'download'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom phone-1-change', 'name' => 'rtf-button', 'value' => 1]) ?>
                </div>

            </div>


            <?php ActiveForm::end(); ?>


            <?php echo '';//Pjax::end(); ?>


        </div>
    </div>


</div>