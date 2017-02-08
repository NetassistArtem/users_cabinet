<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = Yii::t('support_history','support_history');



?>
<div class="site-about" >
    <div class="title_custom" >
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class="table-responsive" >
        <table class="table table-bordered table-border-custom table_support_history" >
            <thead>
            <tr>
                <th colspan="7"><?= Yii::t('support_history','history_appeals') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>№</td>
                <td>TODO id</td>
                <td><?= Yii::t('support_history','status') ?></td>
                <td><?= Yii::t('support_history','initialization_time') ?></td>
                <td><?= Yii::t('support_history','end_time') ?></td>
                <td><?= Yii::t('support_history','executor') ?></td>
                <td><?= Yii::t('support_history','subject') ?></td>
            </tr>

            <?php foreach($todo_history_array as $k => $v): ?>


                <tr>

                    <td><?= $k+1 ?></td>
                    <td class="btn-custom" ><a href="/istoriya-obrascheniy/<?= $v['todo_id'] ?>"><?= $v['todo_id'] ?></a></td>
                    <td><?= $v['todo_state'] ?></td>
                    <td><?= $v['todo_init_time'] ?></td>
                    <td><?= $v['todo_end_time'] ?></td>
                    <td><?= $v['todo_admin_id'] ?></td>
                    <td><?= $v['todo_subj'] ?></td>

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