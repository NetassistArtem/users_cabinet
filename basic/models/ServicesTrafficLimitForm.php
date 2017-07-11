<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class ServicesTrafficLimitForm extends Model
{


    public $traffic_change;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['traffic_change'], 'required'],
            //[['services'], 'trim'],
          //  [['from_date'],'date','format' => 'd.m.Y']


        ];
    }

    public function trafficLimitOnOff()
    {

        if ($this->validate()) {

            $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
          //  get_access_filter($acc_id, $filter_id);
          //  $on_off = $user_data['yandex_filter'] == 0
            set_access_filter($user_data['account_id'], FILTER_VKOK_ID, $this->traffic_change);

         //   event_log2('common.user.inc.php', $this->user_data['net_id'], $this->user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'], -1, -1,-1,-1, 'Block Yandex,VK,etc');//функция биллинга записывает инфу в лог
            //Debugger::EhoBr($this->traffic_change);
            //Debugger::testDie();
            // $services = Yii::$app->request->post('ServicesChangePauseFinishForm')['services'];
          //  $svc_info = $user_data['svc'][$services];

         //   Debugger::Eho($services);
           // Debugger::PrintR($svc_info);
          //  Debugger::VarDamp($pause_ptime_stamp);
          //  Debugger::PrintR($_POST);
         //   Debugger::testDie();
          //  Debugger::VarDamp(resume_svc($svc_info));
           // Debugger::testDie();
       //     if(resume_svc($svc_info)){//функция биллинга, запускает паузу
         //       event_log2('common.svc.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $user_data['loc_id'],-1,-1,-1,-1,'Stop pause');//функция биллинга записывает инфу в лог
                Yii::$app->session->setFlash('servicesTrafficLimit',['value' => Yii::t('flash-message', 'traffic_limit_change')]);
              //  Yii::$app->session->setFlash('servicesChangedPauseInformation',['value' => Yii::t('flash-message', 'pause_information')]);
                return true;
            }else{
                Yii::$app->session->setFlash('servicesTrafficLimit',['value' => Yii::t('flash-message', 'traffic_limit_not_change')]);
                return false;
            }

    //    } else {

      //      return false;
        //}
    }


}