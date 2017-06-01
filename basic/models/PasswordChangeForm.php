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
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        if($this->validate()){
            $password_change = $this->insertNewPassword();
            //Debugger::VarDamp($password_change);
            if($password_change === 0){ //валидация пароля на уровне биллинга
                Yii::$app->session->setFlash('passwordChanged',['value' => Yii::t('flash-message', 'password_saved')]);

             //   event_log('common.acl.inc.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'], -1, -1, 'Successful password change');//функция биллинга записывает инфу в лог
            }else{
                Yii::$app->session->setFlash('bad_password',['value' => $password_change]);

            }
            return true;
        }else{
            Yii::$app->session->setFlash('passwordChanged',['value' => Yii::t('flash-message', 'password_not_changed')]);
          //  event_log('common.acl.inc.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'], -1, -1, 'Password Change Error');//функция биллинга записывает инфу в лог
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