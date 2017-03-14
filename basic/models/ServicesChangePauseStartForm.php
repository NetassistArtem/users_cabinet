<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class ServicesChangePauseStartForm extends Model
{

    public $from_date;
    public $services;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['services','from_date'], 'required'],
            [['services'], 'trim'],
          //  [['from_date'],'date','format' => 'd.m.Y']


        ];
    }

    public function setPause()
    {
        if ($this->validate()) {

            $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
             $services = Yii::$app->request->post('ServicesChangePauseStartForm')['services'];
            $pause_start_time = Yii::$app->request->post('ServicesChangePauseStartForm')['from_date'];
           // Debugger::PrintR($user_data['services_tariff_info'][$testt]);
            $pause_ptime_stamp = str_to_ptime_stamp_ex($pause_start_time); //функция биллинга по преобразованию даты
          //  Debugger::VarDamp($pause_ptime_stamp);
           // Debugger::PrintR($user_data['svc'][$services]);
         //   Debugger::VarDamp(pause_svc($user_data['svc'][$services], $pause_ptime_stamp));
          //  Debugger::testDie();
            $t = 0;
            if(pause_svc($user_data['svc'][$services], $pause_ptime_stamp)){//функция биллинга, запускает паузу
                Yii::$app->session->setFlash('servicesChangedPause',['value' => Yii::t('flash-message', 'pause_start').$pause_start_time]);
                Yii::$app->session->setFlash('servicesChangedPauseInformation',['value' => Yii::t('flash-message', 'pause_information')]);
                return true;
            }else{
                Yii::$app->session->setFlash('servicesChangedPause',['value' => Yii::t('flash-message', 'pause_start_fail')]);
                return false;
            }

        } else {

            return false;
        }
    }


}