<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class ServicesChangePauseFinishForm extends Model
{


    public $services;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['services'], 'required'],
            [['services'], 'trim'],
          //  [['from_date'],'date','format' => 'd.m.Y']


        ];
    }

    public function deletePause()
    {

        if ($this->validate()) {

            $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
             $services = Yii::$app->request->post('ServicesChangePauseFinishForm')['services'];
            $svc_info = $user_data['svc'][$services];

         //   Debugger::Eho($services);
           // Debugger::PrintR($svc_info);
          //  Debugger::VarDamp($pause_ptime_stamp);
          //  Debugger::PrintR($_POST);
         //   Debugger::testDie();
          //  Debugger::VarDamp(resume_svc($svc_info));
           // Debugger::testDie();
            if(resume_svc($svc_info)){//функция биллинга, запускает паузу
                event_log2('common.svc.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $user_data['loc_id'],-1,-1,-1,-1,'Stop pause');//функция биллинга записывает инфу в лог
                Yii::$app->session->setFlash('servicesChangedPause',['value' => Yii::t('flash-message', 'pause_finish')]);
                Yii::$app->session->setFlash('servicesChangedPauseInformation',['value' => Yii::t('flash-message', 'pause_information')]);
                return true;
            }else{
                Yii::$app->session->setFlash('servicesChangedPause',['value' => Yii::t('flash-message', 'pause_finish_fail')]);
                return false;
            }

        } else {

            return false;
        }
    }


}