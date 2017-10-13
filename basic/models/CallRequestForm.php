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

            ['phone', 'match', 'pattern' => '/^((0\d{2})-?)?(\d{3})(-?\d{2})(-?\d{2})$/', 'message' => Yii::t('flash-message', 'phone_format')],// '/^((\+?38)(-?\d{3})-?)?(\d{3})(-?\d{2})(-?\d{2})$/'


        ];
    }

    public function setCallRequest()
    {

        if ($this->validate()) {


            //if($this->sendPhone()){
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
        if (!Yii::$app->user->isGuest) {
            User::UserData();
        }
        $phone_number = '+38' . Yii::$app->request->post('CallRequestForm')['phone'];
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $user_name = isset($user_data['username']) ? $user_data['username'] : transcode_utf8_to_internal('Не зарегистрированный пользователь');
        $acc_id = isset($user_data['account_id']) ? $user_data['account_id'] : -1;

        //если пользователь не залогинен, проверка по телефону, есть ли он в базе
        if (!$user_data['username']) {
            $search = array('+', '*', '(', ')', ' ', '-', '_', '/');
            $phone = str_replace($search, '', $phone_number);

            $contact_id_array = find_contacts($phone, PRINT_CONTACTS_GET_LIST_EX);
            //  Debugger::PrintR($contact_id_array);
            // Debugger::testDie();
            $register_user = '';
            if (!empty($contact_id_array)) {

                foreach ($contact_id_array as $k => $v) {
                    $c_i = get_contact_info($k);
                    //    Debugger::EhoBr($c_i[CONTACTS_USER_IDX]);

                    //       Debugger::PrintR($c_i);

                    if ($c_i[CONTACTS_DEL_MARK_IDX] != 1 && $c_i[CONTACTS_USER_ID_IDX] != -1) {
                        $user_data_by_phone = get_user_info_by_ids($c_i[CONTACTS_USER_ID_IDX]);
                        //  Debugger::PrintR($user_data);
                        //   Debugger::EhoBr(CONTACTS_USER_IDX);
                        // Debugger::testDie();
                        if ($user_data_by_phone[UINFO_DEL_MARK_IDX] != 1) {
                            $register_user = 1;
                            $acc_id = $user_data_by_phone[UINFO_ACC_ID_IDX];
                            $user_name = $user_data_by_phone[UINFO_NAME_IDX];

                        }
                    }


                }
            }

            // Debugger::PrintR($todo_ctx);
            //  Debugger::Eho($acc_id);
            //Debugger::testDie();
        }
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
        $search = array('*', '(', ')', ' ', '-', '_', '/');
        $phone_number = str_replace($search, '', $phone_number);


        $todo_ctx = array(
            "subj" => transcode_utf8_to_internal('Обращение в тех-поддержку') . ' user: ' . $user_name . ', ' . transcode_utf8_to_internal('запрос call-back'),
            "ref_acc_id" => $acc_id,
            "todo_desc" => transcode_utf8_to_internal("Перезвоните мне на номер ") . $phone_number, //  transcode_utf8_to_internal("(TEST)Перезвоните мне на номер").$phone_number,  // iconv_safe('utf-8','koi8-u',  "(TEST)Перезвоните мне на номер").$phone_number,
            "todo_type" => TODO_SUPPORT,
            "todo_state" => REQ_TYPE_CALL,
            "exec_list" => "@duty",

        );

        new_todo_simple(0, TODO_SUPPORT, $todo_ctx,
            -1, $acc_id, -1);

        return '';
    }

}