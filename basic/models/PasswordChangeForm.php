<?php


namespace app\models;


use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class PasswordChangeForm extends Model
{

    public $oldPassword;
    //public $oldPasswordRepeat;
    public $newPassword;
    public $newPasswordRepeat;
   // private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['oldPassword','newPasswordRepeat', 'newPassword' ], 'required'],

            [['oldPassword','newPasswordRepeat', 'newPassword' ], 'trim'],

            ['newPassword', 'compare', 'compareAttribute' => 'newPasswordRepeat'],

            ['oldPassword', 'compare', 'compareValue' => Yii::$app->user->identity->password, 'message' =>Yii::t('upravlenie-kabinetom','wrong_password')],

            [['newPasswordRepeat', 'newPassword' ], 'string', 'length' =>[6 , 12]],

        ];
    }

    public function setNewPassword(){
        if($this->validate()){
            $password_change = $this->insertNewPassword();
            if($password_change === 0){ //валидация пароля на уровне биллинга
                Yii::$app->session->setFlash('passwordChanged',['value' => 'Новый пароль сохранен.']);
            }else{
                Yii::$app->session->setFlash('bad_password',['value' => $password_change]);
            }


            return true;
        }else{
            Yii::$app->session->setFlash('passwordChanged',['value' => 'Пароль не изменен']);
            return false;
        }
    }

    public function insertNewPassword(){

        //Debugger::VarDamp(upd_htpwd(Yii::$app->user->identity->username, Yii::$app->request->post('PasswordChangeForm')['newPassword'], OPT_PWD_DB));

//Debugger::testDie();
        $password_change = upd_htpwd(Yii::$app->user->identity->username, Yii::$app->request->post('PasswordChangeForm')['newPassword'],OPT_PWD_DB | OPT_PWD_VALIDATE );

        return $password_change;
    }








}