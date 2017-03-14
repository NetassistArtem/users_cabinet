<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class RtfPrintForm extends Model
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

    public function createRtf()
    {
        if ($this->validate()) {

            $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

         //   Debugger::Eho($t);
          //  Debugger::testDie();

           global $included;
            global $rtf;
        //    global $verbose;
            global $force_output;
            global $force_to_pay;
            $force_to_pay = Yii::$app->request->post('RtfPrintForm')['many']*1000;

            $included = 1;
            $rtf=1;
         //   $verbose=1;
            $force_output=1;

            require_once(__DIR__ . '/../components/billing_api/admin/invoice.php');
          //  Debugger::testDie();



          //  return true;
        } else {
            Yii::$app->session->setFlash('credit',['value' => Yii::t('flash-message', 'rtf_fail')]);

            return false;
        }
    }


}