<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class ContactChangeForm extends Model
{

    public $phone1;
    //public $oldPasswordRepeat;
    public $phone2;
    public $email;
    // private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['phone1', 'phone2', 'email'], 'trim'],

            ['email', 'email'],


        ];
    }

    public function setNewContact()
    {
        if ($this->validate()) {
            Yii::$app->session->setFlash('contactChanged', ['value' => 'Контактные данные были успешно изменены.']);
            $this->insertNewContact();
            return true;
        } else {
            Yii::$app->session->setFlash('contactChanged', ['value' => 'Не удалось изменить контактные данные']);
            return false;
        }
    }

    public function insertNewContact()
    {
        return '';
    }

}