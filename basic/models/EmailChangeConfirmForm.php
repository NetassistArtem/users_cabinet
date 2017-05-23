<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\components\sms_handler\UserSms;
use app\components\user_contacts_update\UserContactsUpdate;


class EmailChangeConfirmForm extends Model
{

    public $confirmcode;
    public $user_data;
    public $email;

    public function __construct($config = [])
    {
        $this->email = Yii::$app->session->get('new_user_phone_or_email');
        $this->user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        parent::__construct($config);
    }


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

                // Debugger::VarDamp($confirm);
                // Debugger::testDie();

                if ($confirm === 2) {
                    event_log('common.contacts.php', $this->user_data['net_id'], $this->user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'],-1,-1,'Error change/add user contacts (e-mail).Wrong verification code.');//функция биллинга записывает инфу в лог
                    Yii::$app->session->setFlash('codeConfirm', ['value' => Yii::t('flash-message', 'wrong_code')]);
                    return 2;
                }

                //Debugger::PrintR($_SESSION);
                // Debugger::Eho(Yii::$app->session->get('normal_phone'));


                $email_new = $this->email;

            //    Debugger::EhoBr($email_new);
                //  Debugger::Eho($user_phone_new);
                //  Debugger::testDie();
                //  Debugger::Eho(Yii::$app->session->get('normal_phone'));
                //Debugger::Eho('test');
                //

                if (!Yii::$app->session->get('add')) {
                    $email_old = Yii::$app->session->get('email_to_change');
                    $user_contact_info = get_user_contacts('', -1, -1, Yii::$app->user->id, -1, -1, -1, -1, "", -1, "", 0, PRINT_CONTACTS_GET_LIST_EX);  //получить массив контактов ($contact_info)
                    $contact_id = '';

                    foreach ($user_contact_info as $value) {
                        if ($value[CONTACTS_EMAIL_IDX] == $email_old) {
                            $contact_id = $value[CONTACTS_RECORD_ID_IDX];
                        }
                    }


                    del_restore_contact($contact_id, 1);

                } else {
                    $user_contact_info = get_user_contacts('', -1, -1, Yii::$app->user->id, -1, -1, -1, -1, "", -1, "", 0, PRINT_CONTACTS_GET_LIST_EX);  //получить массив контактов ($contact_info)

                }

      //          $isset_history = 0;
        //        foreach($user_contact_info as $k=>$v){
          //          if($v[CONTACTS_EMAIL_IDX] == $email_new){
            //            $isset_history = 1;
              //          break;
                //    }
               // }

//if($isset_history){
  //  del_restore_contact($contact_id, 0);

//}

                update_user_contacts('',  //функция апи биллинга, добавляет контакт пользователя (но не добавляет в поле user_phone)
                    CONTACT_USER . "," . CONTACT_REQ, CONTACT_USER, "", 0, UNDEL_CONTACT,
                    $this->user_data['username'], $this->user_data['real_name'], $this->user_data['address'], $this->user_data['account_id'], Yii::$app->user->id, $this->user_data['net_id'], $this->user_data['loc_id'], $this->user_data['req_id'], $email_new, -1, $user_contact_info[0][CONTACTS_PERSON_ID_IDX]);




                event_log('common.contacts.php', $this->user_data['net_id'], $this->user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'], -1, -1, -1);//функция биллинга записывает инфу в лог

                $user_contact_info_all = get_user_contacts('', -1, $this->user_data['account_id'], -1, -1, -1, -1, -1, "", -1, "", 0, PRINT_CONTACTS_GET_LIST_EX); //функция апи биллинга

           //     Debugger::PrintR($user_contact_info_all);
                $email_active = array();


                foreach ($user_contact_info_all as $val) {
                    if ($val[CONTACTS_DEL_MARK_IDX] == 0) {
                        if ($val[CONTACTS_EMAIL_IDX]) {
                            $email_active[] = $val[CONTACTS_EMAIL_IDX];
                        }

                    }
                }

                $email_active = array_unique($email_active);
      //          Debugger::PrintR($email_active);
                 // Debugger::PrintR($this->user_data);
        //          Debugger::testDie();
                global $acc_db;
                global $acc_db_host;
                global $acc_db_user;
                global $acc_db_pwd;

                $update_email_fields = new UserContactsUpdate(Yii::$app->user->id, array(), $email_active);

                // Debugger::Eho($acc_db);


                //Debugger::PrintR($phones_active);
                //Debugger::testDie();

                // del_restore_contact($contact_id, 1); //функция биллинка - включает для сохраненного телефона пометку - ДОСТУПЕН
                //  Debugger::testDie();
                $update_email_fields->updateEmailFields($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);



               // update_contact_fields($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd, Yii::$app->user->id,array(), $email_active,1, 2);




            }

            return true;
        } else {

            return false;
        }
    }

    public function sendConfirmCode()
    {


        if (UserSms::checkCode($this->confirmcode)) {

            return true;
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