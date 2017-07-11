<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\debugger\Debugger;
use app\components\user_contacts_update\Conn_db;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
  //  public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
         //   ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            [['username', 'password'], 'trim'],
            ['password', 'validatePassword']

        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {

           if (!$this->hasErrors()) {
            $user = $this->getUser();

               $host = Yii::$app->params['domains'][$_SERVER['SERVER_NAME']];

               $user_org_id_check = 0;
               if($host == 'kuzia' && $user->orgId == 7){
                   $user_org_id_check = 1;
               }elseif($host == 'alfa' && $user->orgId == 0){
                   $user_org_id_check = 1;
               }else{
                   $user_org_id_check = 0;
               }

            if (!$user || !$user_org_id_check || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        $security_key_get = false;
        $security_key_post = false;
        if(Yii::$app->request->get('ses_id') && Yii::$app->request->get('key')){
            $security_key_get = md5(Yii::$app->request->get('ses_id').Yii::$app->params['security_key'])== Yii::$app->request->get('key');
            //
        }elseif(Yii::$app->request->post('ses_id') && Yii::$app->request->post('key')){
            $security_key_post = md5(Yii::$app->request->post('ses_id').Yii::$app->params['security_key']) == Yii::$app->request->post('key');
        }

        if((Yii::$app->request->get('ses_id') && $security_key_get && Yii::$app->params['get_session'] == 1) || (Yii::$app->request->post('ses_id') && $security_key_post)){
         return  $this->BillingIdentity();
        }

        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {

            $this->_user = User::findByUsername($this->username);
        }



        return $this->_user;
    }

    public function BillingIdentity(){
        global $acc_db_host;
        global $acc_db;
        global $acc_db_user;
        global $acc_db_pwd;

        $dbc = Conn_db::getConnection($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);
        $ses_id = Yii::$app->request->post('ses_id')? Yii::$app->request->post('ses_id') : Yii::$app->request->get('ses_id');

        $sql = 'SELECT * FROM `ses_list` WHERE  `ses_id` = :ses_id';
        $placeholders = array(
            'ses_id' => $ses_id,
        );
        $data = $dbc->getDate($sql,$placeholders);
       // Debugger::PrintR($data);
       // Debugger::testDie();
        if(!empty($data)){
            $this->username = $data[0]['user_name'];
            $_POST['username'] = $data[0]['user_name'];
          //  Debugger::EhoBr();
           // Debugger::EhoBr(Yii::$app->request->post('username'));
          //  Debugger::EhoBr($this->username);
           // Debugger::testDie();
            return Yii::$app->user->login($this->getUser(),0);
        }

        return false;
    }
}
