<?php
use yii\bootstrap\Modal;






Modal::begin([
    'header' => '<h3>'.Yii::t('call-request', 'test').'</h3>',
    'headerOptions' => ['id' => 'modalHeader','class'=>'modal_3_header'],
    'id' => 'modal-user-code',
    //   'size' => 'modal-lg',
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
    'options'=>['class'=>'modal_3_wrapper'],



]); ?>

<?php

Modal::end();




?>