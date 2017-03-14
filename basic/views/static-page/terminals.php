<?php

use yii\helpers\Html;

$this->title = Yii::t('terminals','terminals_title');

?>
<div class="site-about">
    <div class="title_custom">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="content_tv">
        <div>
            <h3><?= Yii::t('terminals','for_terminals_need')?></h3>
            <ol>
                <li>
                    <p>
                        <i class="message_main_text"><?= Yii::t('terminals','need_1')?></i>
                    </p>
                </li>
                <li>
                    <p>
                        <i class="message_main_text"><?= Yii::t('terminals','need_2')?></i>
                    </p>
                </li>
                <li>
                    <p>
                        <i class="message_main_text"><?= Yii::t('terminals','need_3')?></i> <i class="red message_main_text"><?= $user_data['username']; ?></i>
                    </p>
                    <p>
                        <i class="message_main_text"><?= Yii::t('terminals','need_4');?></i> <i class="red message_main_text"><?= $user_data['pin']; ?></i>
                    </p>
                </li>
                <li>
                    <p>
                        <i class="message_main_text"><?= Yii::t('terminals','need_5')?></i>
                    </p>
                    <p>
                        <i class="message_main_text"><?= Yii::t('terminals','need_6')?></i>
                    </p>
                    <p>
                        <i class="message_main_text"><?= Yii::t('terminals','need_7')?></i>
                    </p>
                </li>
            </ol>



        </div>

    </div>


    <div class="table-responsive">
        <table class="table table-bordered  table-border-custom" >
            <thead>
            <tr>
                <th colspan="3"><?= Yii::t('terminals','terminals_address')?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>№</td>
                <td><?= Yii::t('terminals','address')?></td>
            </tr>
            <?php for($i = 1; $i <= 20; $i ++ ): ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= Yii::t('terminals',"addr_$i")?></td>
                </tr>
            <?php endfor; ?>

            <tr>

                <td class="btn-custom" colspan = "3" ><a  href="http://24nonstop.com.ua/Customers/TerminalMap"><?= Yii::t('terminals','all_terminals')?></a></td>

            </tr>

            </tbody>
        </table>
    </div>


</div>