<?php
namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\components\sms_handler\UserSms;
use app\components\user_contacts_update\UserContactsUpdate;
use app\components\user_contacts_update\SmsStatistics;


class RenewPasswordConfirmForm extends Model
{

    public $confirmcode;
    public $user_name;
    public $new_password;



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

    public function setConfirmCode($contact_type, $contact_value)
    {




        if ($this->validate()) {
            $user_id = Yii::$app->session->get('userid_password_renew');


            //if($this->sendPhone()){
            $confirm = $this->sendConfirmCode();

            if ($confirm) {

                // Debugger::VarDamp($confirm);
                // Debugger::testDie();

                if ($confirm === 2) {

                    event_log2('common.contacts.php', -1, -1, $user_id, -1, -1,-1,-1,-1,-1,'Error change/add user contacts (phone number).Wrong verification code.');//функция биллинга записывает инфу в лог

                    Yii::$app->session->setFlash('codeConfirm', ['value' => Yii::t('flash-message', 'wrong_code')]);
                    return 2;
                }

                $code_creator= new UserSms();
                $new_password = $code_creator->codeCreate(
                    Yii::$app->params['renew_password']['verification_cod_length'],
                    Yii::$app->params['renew_password']['verification_cod_num'],
                    Yii::$app->params['renew_password']['verification_cod_down_chars'],
                    Yii::$app->params['renew_password']['verification_cod_up_chars']
                );

                $user_name = Yii::$app->session->get('username_password_renew');

                $password_change = upd_htpwd($user_name, $new_password ,OPT_PWD_DB | OPT_PWD_VALIDATE );

                if($password_change === 0){

                    event_log2('common.contacts.php', -1, -1, $user_id, -1, -1,-1,-1,-1,-1,'Change password.');//функция биллинга записывает инфу в лог

                        $this->sendNewPasswordMessage($contact_type, $contact_value,$user_name,$new_password);

                }else{
                    Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'not_change_password')]);
                }

            }

            return true;
        } else {

            return false;
        }
    }

    public function sendConfirmCode()
    {


        if (UserSms::checkCode($this->confirmcode)) {
            if (Yii::$app->session->has('confirmcode')) {

                Yii::$app->session->remove('confirmcode');
            }
            if (Yii::$app->session->has('renew_password_phone')) {

                Yii::$app->session->remove('renew_password_phone');
            }
            if (Yii::$app->session->has('renew_password_email')) {

                Yii::$app->session->remove('renew_password_email');
            }

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

    public function sendNewPasswordMessage($contact_type, $contact_value, $user_name, $new_password){  //$contact_type = 'phone' || 'email'

        if($contact_type == 'email'){
            $email_text = Yii::t('sms_messages', 'login').$user_name.'; '.Yii::t('sms_messages', 'new_pass').$new_password;

            $subject = Yii::t('sms_messages', 'new_password_subj');
            global $_admin_mail;
            $from_mail = $_admin_mail;
            $server_name = Yii::$app->params['server_name'];
            $domains_key = Yii::$app->params['domains'][$server_name];
            $from_user = Yii::t('site','admin') . Yii::t('site', Yii::$app->params['sites_data'][$domains_key]['company_name']['lang_key']);


            // turbosms_send($normal_phone, $full_sms_text, $org_id, 0, $acc_id); //Открпвка смс, функция биллинга

            //$contact_value
            my_mail( $contact_value, iconv_safe('utf-8','koi8-u',$email_text), iconv_safe('utf-8','koi8-u',$subject), $from_mail, $from_user);

            Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'new_password_send_by_email')]);

        }elseif($contact_type = 'phone'){

            turbosms_init($verbose = 1);//функция из апи биллинга, инициализирует работу с смс сообщениями
            ast_init();//функция из апи биллинга
            $normal_phone = asterisk_normalize_phone($contact_value);//функция из апи биллинга, нормализирует телефон отправленный пользователем

            $number_valid = ast_get_sms_route($normal_phone, 1);

            if ($number_valid !== -1) { //функция из апи биллинга, проверяет номер на возможность отправки смс.

                $sms_text = Yii::t('sms_messages', 'login').$user_name.'; '.Yii::t('sms_messages', 'new_pass').$new_password;
//Дальнейшее ограничение на отправку смс только с целью безопасности, оснавная проверка идет на этапе отправки проверочного кода.Но фиксация времени отправки необходима

                global $acc_db_host;
                global $acc_db;
                global $acc_db_user;
                global $acc_db_pwd;

                $sms_statistics = new SmsStatistics($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);
                $sms_statistics->deleteOld(Yii::$app->params['sms_time_limit_delete']);
                $sms_limit = Yii::$app->params['sms_limit_pass_renew'];
                $user_id = Yii::$app->session->get('userid_password_renew');
                Yii::$app->session->remove('userid_password_renew');
                if ($sms_statistics->smsLimit($user_id, Yii::$app->params['sms_time_limit'], $sms_limit)) {
                    //$normal_phone
                    turbosms_send($normal_phone, iconv_safe('utf-8','koi8-u',$sms_text), ''); //Открпвка смс, функция биллинга
                    $sms_statistics->insertData($user_id);
                } else {
                    Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'limit_sms_send')]);
                    return false;
                }

                Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'new_password_send_by_sms')]);

            }else{
                Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'not_good_number_format')]);
            }

        }else{

            return false;

        }
      //  Debugger::testDie();
    }

}