<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;


class CallRequestForm extends Model
{

    public $phone;




    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['phone'], 'required'],

            ['phone', 'match', 'pattern' => '/^((0\d{2})-?)?(\d{3})(-?\d{2})(-?\d{2})$/', 'message' => 'Номер должен быть в формате 099-999-99-99'],// '/^((\+?38)(-?\d{3})-?)?(\d{3})(-?\d{2})(-?\d{2})$/'


        ];
    }

    public function setCallRequest()
    {
        if ($this->validate()) {


            //if($this->sendPhone()){
                Yii::$app->session->setFlash('flash_message', ['value' => 'Звонок заказан']);
            $this->sendPhone();
          //  Debugger::VarDamp($t);
          //  }else{
            //    Yii::$app->session->setFlash('flash_message', ['value' => 'Ошибка заказа звонка']);
         //   }
            return true;
        } else {

            return false;
        }
    }

    public function sendPhone()
    {
        global $opt_vars;
        global $todo_ctx;
        User::UserData();
        $phone_number = Yii::$app->request->post('CallRequestForm')['phone'];
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $user_name = isset($user_data['username']) ? $user_data['username'] : '';
        $acc_id = isset($user_data['account_id']) ? $user_data['account_id'] : -1;
        $new_ctx = array(
            "subj" => "TEST user $user_name, запрос call-back",
            "ref-acc_id" => $acc_id,
            "todo_desc" => "(TEST)перезвоните мне на номер $phone_number",
            "todo_type" => TODO_SUPPORT,
            "todo_state" => REQ_TYPE_CALL,
            "exec_list" => "@duty",

        );

        todo_ctx_init_new(
            0,
            TODO_SUPPORT,
            $opt_vars,
            $todo_ctx,
            $new_ctx,
            -1,
            $acc_id
            );


        $t = todo_ctx_save(0, $todo_ctx, 0);
        Debugger::VarDamp($t);
        return '';
    }

}