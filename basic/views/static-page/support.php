<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use app\assets\AppAsset;

$this->title = Yii::t('support', 'technical_support');

//$server_name = Yii::$app->params['server_name'];
//$style = Yii::$app->params['domains'][$server_name];


?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class=" panel panel-default cabinet_change_forms">
        <div class="panel-heading">
            <p><?= Yii::t('support', 'select_problem') ?></p>
        </div>
        <div class="panel-body">



            <div>

                <?php
                $flash_message = Yii::$app->session->getFlash('selectProblem')['value'];

                if (isset($flash_message)):


                    // $this->registerJs('$("#modal").modal("show");');
                    echo Yii::$app->view->renderFile('@app/views/static-page/modal/modal_1.php', ['flash_message' => $flash_message]);
                    $this->registerJsFile(
                        'scripts/message.js',
                        ['depends' => 'app\assets\AppAsset']
                    );
                endif;
                ?>

            </div>


            <?php $form_select_problem = ActiveForm::begin([
                'id' => 'supportForm',
                'options' => ['data-pjax' => false],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5\">{input}</div>\n<div class=\"col-lg-3 col-md-3 col-sm-3\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],

            ]); ?>






            <?= $form_select_problem->field($modelSupport, 'problem')->label(Yii::t('support', 'problem_type'))->radioList($problem_types); ?>


            <div class="form-group">
                <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                    <?= Html::submitButton(Yii::t('support', 'next'), ['class' => 'btn btn-primary btn-block btn-lg btn-submit-custom', 'name' => 'problem-type-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>




        </div>
    </div>



</div>