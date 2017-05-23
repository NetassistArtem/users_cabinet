<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title =  Yii::t('payment_history','payment_history');

?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class="table-responsive" >
        <table class="table table-bordered table-border-custom table_support_history" >
            <thead>
            <tr>
                <th colspan="6"><?= Yii::t('payment_history','history_appeals') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr class="title_text" >
                <td>№</td>
                <td><?= Yii::t('payment_history','date') ?></td>
                <td><?= Yii::t('payment_history','payment_purpose') ?></td>
                <td><?= Yii::t('payment_history','main_acc') ?></td>
                <td><?= Yii::t('payment_history','credit_acc') ?></td>
                <td><?= Yii::t('payment_history','type') ?></td>
            </tr>

            <?php foreach($payment_history_page as $k => $v): ?>


                <tr>

                    <td><?= $k+1 ?></td>
                    <td><?= $v['date'] ?></td>
                    <td><?= $v['payment_purpose'] ?></td>
                    <td><?= $v['main_acc'] ?></td>
                    <td><?= $v['credit_acc'] ?></td>
                    <td><?= $v['type'] ?></td>

                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 pagination-custom">
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>

    </div>




</div>