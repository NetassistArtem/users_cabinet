<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class CreditForm extends Model
{

    public $many;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['many'], 'required'],
            [['many'], 'trim'],
            [['many'], 'number'],



        ];
    }

    public function setCredit()
    {
        if ($this->validate()) {

            $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

            $ptime_stamp = str_to_ptime_stamp_ex(Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd H:i:s')); //функция биллинга по преобразованию даты



           // Debugger::testDie();
            $activation_services = svc_has_transition_state($user_data['account_id']);//функция билига, проверка на наличие услуг в состояни активации

            if(!$activation_services){
                $many = Yii::$app->request->post('CreditForm')['many'];
                if($many <= $user_data['account_max_credit']){

                  $service_fore_credit = array_search(0,$user_data['svc_credit_allowed']);
                    $service_fore_autocredit = array_search(2,$user_data['svc_credit_allowed']);

                    if($service_fore_credit !== false){// ||$service_fore_autocredit !== false) {


                        $svc_code = svc_encode($user_data['svc_type_id'][$service_fore_credit], $user_data['svc_subtype_id'][$service_fore_credit]);
                        $comment = '+'.round($many/($user_data['services_tariff_month_price'][$service_fore_credit]/30),1) . 'days';
//Debugger::VarDamp($svc_code);
                    //    Debugger::Eho($many);
                       // Debugger::Eho('$ptime_stamp = '.$ptime_stamp);
                      //  Debugger::Eho('$many = '.$many);
                     //   Debugger::Eho($user_data['svc_type_id'][$service_fore_credit]);
                     //   Debugger::Eho($user_data['svc_subtype_id'][$service_fore_credit]);
                      // Debugger::Eho('$svc_code = '.$svc_code);
                   //     Debugger::VarDamp($svc_code);
                     //   Debugger::testDie();
                       // _is_admin();

                        $t = pay_make_credit($user_data['account_id'], $user_data['org_id'], $ptime_stamp, $comment, $many*1000, 0, $svc_code, 1);
                       // Debugger::VarDamp($t);
                       // Debugger::testDie();
                        if($t != false){
                            Yii::$app->session->setFlash('credit', ['value' => Yii::t('flash-message', 'credit_ok').$many .' '. $user_data['account_currency']]);
                            return true;
                        }else{
                            Yii::$app->session->setFlash('credit',['value' => Yii::t('flash-message', 'credit_fail')]);
                            return false;
                        }

                    }elseif($service_fore_autocredit !== false){
                        Yii::$app->session->setFlash('credit',['value' => Yii::t('flash-message', 'autocredit')]);
                        return false;

                    }else{
                        Yii::$app->session->setFlash('credit',['value' => Yii::t('flash-message', 'credit_fail_condition')]);
                        return false;
                    }

                }else{
                    Yii::$app->session->setFlash('credit',['value' => Yii::t('flash-message', 'credit_limit').$many .' '. $user_data['account_currency']]);
                    return false;
                }

            }else{
                Yii::$app->session->setFlash('credit',['value' => Yii::t('flash-message', 'credit_fail')]);
                return false;
            }

        } else {
            Yii::$app->session->setFlash('credit',['value' => Yii::t('flash-message', 'credit_fail')]);

            return false;
        }
    }


}