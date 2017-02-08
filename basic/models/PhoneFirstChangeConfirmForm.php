<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\components\sms_handler\UserSms;


class PhoneFirstChangeConfirmForm extends Model
{

    public $confirmcode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['confirmcode'], 'required'],
            [['confirmcode'], 'trim'],

        ];
    }

    public function setConfirmCode()
    {
        if ($this->validate()) {


            //if($this->sendPhone()){
            $confirm = $this->sendConfirmCode();

            if ($confirm) {
                if ($confirm == 2) {

                    Yii::$app->session->setFlash('codeConfirm', ['value' => Yii::t('flash-message', 'wrong_code')]);
                    return 2;
                }
            }


            //  Debugger::VarDamp($t);
            //  }else{
            //    Yii::$app->session->setFlash('flash_message', ['value' => 'Ошибка заказа звонка']);
            //   }
            return true;
        } else {

            return false;
        }
    }

    public function sendConfirmCode()
    {

        if (UserSms::checkCode($this->confirmcode)) {
         //   Debugger::Eho(Yii::$app->session->get('new_user_phone_or_email'));
           // Debugger::testDie();
        } else {

            return 2;
        }
        // Debugger::testDie();
        //  User::UserData();
        //    $phone_number = Yii::$app->request->post('CallRequestForm')['phone'];
        //  $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        //  $user_name = isset($user_data['username']) ? $user_data['username'] : '';
        //  $acc_id = isset($user_data['account_id']) ? $user_data['account_id'] : -1;
        /*
                $new_ctx = array(
                    "subj" => "TEST user $user_name, запрос call-back",
                    "ref_acc_id" => $acc_id,
                    "todo_desc" =>  transcode_utf8_to_internal("(TEST)Перезвоните мне на номер").$phone_number, //  transcode_utf8_to_internal("(TEST)Перезвоните мне на номер").$phone_number,  // iconv_safe('utf-8','koi8-u',  "(TEST)Перезвоните мне на номер").$phone_number,
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


                todo_ctx_save(0, $todo_ctx, 0);
        */
        /*
        $todo_ctx = array(
            "subj" => transcode_utf8_to_internal('Обращение в тех-поддержку').' user: '. $user_name. ', ' .transcode_utf8_to_internal('запрос call-back'),
            "ref_acc_id" => $acc_id,
            "todo_desc" =>  transcode_utf8_to_internal("Перезвоните мне на номер ").$phone_number, //  transcode_utf8_to_internal("(TEST)Перезвоните мне на номер").$phone_number,  // iconv_safe('utf-8','koi8-u',  "(TEST)Перезвоните мне на номер").$phone_number,
            "todo_type" => TODO_SUPPORT,
            "todo_state" => REQ_TYPE_CALL,
            "exec_list" => "@duty",

        );

        new_todo_simple(0, TODO_SUPPORT, $todo_ctx,
            -1, $acc_id, -1);
*/
        return '';
    }

}