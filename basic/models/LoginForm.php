<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\debugger\Debugger;

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
}
