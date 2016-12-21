<?php
use yii\bootstrap\Modal;






Modal::begin([
    'header' => '<h3>Заказ звонка</h3>',
    'headerOptions' => ['id' => 'modalHeader','class'=>'modal_2_header'],
    'id' => 'modal-contact',
    //   'size' => 'modal-lg',
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
    'options'=>['class'=>'modal_2_wrapper'],



]); ?>

<?php

Modal::end();




?>