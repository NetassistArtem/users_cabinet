<?php


namespace app\components;


use app\components\debugger\Debugger;
use yii\validators\Validator;

class SecureTextValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {

        $value = $model->$attribute;
        $value =  trim($value);

        $value = stripslashes($value);

        $value = strip_tags($value);

        $remuve = array( "''", "", ">", "<");


        $value = htmlspecialchars($value, ENT_QUOTES|ENT_HTML401);
        $value = str_replace($remuve,"",$value);
        $model->$attribute = $value;
    //    Debugger::Eho($model->$attribute);

    }

}