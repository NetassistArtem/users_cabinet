<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class EmailSelectChangeForm extends Model
{

    public $emails;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['emails'], 'trim'],


        ];
    }

    public function setNewEmail()
    {
        if ($this->validate()) {

            $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];




                $email_key = Yii::$app->request->post('EmailSelectChangeForm')['emails'];

                if ($email_key) {

                    $email_val = $user_data['email_array'][$email_key];
                    Yii::$app->session->set('email_to_change', $email_val);
                    return 1;
                } else {
                    Yii::$app->session->setFlash('emailSelectChanged', ['value' => Yii::t('flash-message', 'not_select_email')]);
                    return 2;
                }




            //Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'contact_details_updated')]);
            //$this->insertNewPhone1();
           // return true;
        } else {
            Yii::$app->session->setFlash('phoneSecondChanged', ['value' => Yii::t('flash-message', 'unable_change_contact')]);
            return false;
        }
    }


}