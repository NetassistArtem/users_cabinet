<?php

use yii\bootstrap\Modal;

 Modal::begin([
    'headerOptions' => ['id' => 'modalHeader','class'=>'modal_1_header'],
    'id' => 'modal',
    //   'size' => 'modal-lg',
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
     'options'=>['class'=>'modal_1_wrapper']


]);

echo $flash_message;
                    Modal::end();




?>


