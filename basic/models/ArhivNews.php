<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class ArhivNews extends Model
{

   // public $many;


    /**
     * @return array the validation rules.
     */

    public function getArhiv()
    {
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
     //$test = user_msg_get_global('');


        user_msg_log_add($user_data['account_id'], '', '', '', 49, 'test,test test test', 'test');

////

    $test2 = user_msg_log_get('', $user_data['account_id']);
        Debugger::PrintR($test2);
      //  Debugger::EhoBr($test2);
      //  Debugger::VarDamp($test2);
        Debugger::testDie();


    }


}