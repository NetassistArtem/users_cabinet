<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class PhoneSelectChangeForm extends Model
{

    public $phones;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['phones'], 'trim'],


        ];
    }

    public function setNewPhone()
    {
        if ($this->validate()) {

            $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
            $delete_phone_confirm = Yii::$app->request->post('phone-delete-button') ? Yii::$app->request->post('phone-delete-button') : 0;
            $change_phone_confirm = Yii::$app->request->post('phone-change-button') ? Yii::$app->request->post('phone-change-button') : 0;

            if ($delete_phone_confirm == 1) {

                if ($this->deletePhone()) {
                    Yii::$app->session->setFlash('phoneDeleteChanged', ['value' => Yii::t('flash-message', 'phone_2_delete')]);

                return 3;
                }

            } elseif ($change_phone_confirm == 2) {

                $phone_key = Yii::$app->request->post('PhoneSelectChangeForm')['phones'];

                if ($phone_key) {

                    $phone_val = $user_data['phone_all_array'][$phone_key];
                    Yii::$app->session->set('phone_to_change', $phone_val);
                    return 1;
                } else {
                    Yii::$app->session->setFlash('phoneSelectChanged', ['value' => Yii::t('flash-message', 'not_select')]);
                    return 2;
                }


            }

            //Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'contact_details_updated')]);
            //$this->insertNewPhone1();
            return true;
        } else {
            Yii::$app->session->setFlash('phoneSecondChanged', ['value' => Yii::t('flash-message', 'unable_change_contact')]);
            return false;
        }
    }

    public function insertNewPhone()
    {
        return '';
    }

    public function deletePhone()
    {
        return true;
    }

    public function changePhone()
    {
        return '';
    }

}