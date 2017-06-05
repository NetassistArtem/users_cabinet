<?php


namespace app\models;


use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use yii\web\Controller;
use app\components\sms_handler\UserSms;
use app\components\user_contacts_update\UserContactsUpdate;
use app\components\user_contacts_update\SmsStatistics;

class PhoneFirstChangeForm extends Model
{

    public $phone1;
    public $user_data;
    public $normal_phone;

    /**
     * @return array the validation rules.
     */

    public function __construct($config = [])
    {
        $this->user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        parent::__construct($config);
    }

    public function rules()
    {
        return [

            [['phone1'], 'required'],
            [['phone1'], 'trim'],
            ['phone1', 'match', 'pattern' => '/^((\+380)(\s?\(?\d{2})\)\s?)(\d{3})(\s?\d{2})(\s?\d{2})$/', 'message' => Yii::t('flash-message', 'incorrect_telephone')]
            // [['phone1'],  'length' => [19, 19], 'message' => 'Номер слишком короткий'],


        ];
    }

    public function setNewPhone1()
    {
        // $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];


        if ($this->validate()) {
            $delete_phone_1_confirm = Yii::$app->request->post('phone-first-delete-button') ? Yii::$app->request->post('phone-first-delete-button') : 0;
            $change_phone_1_confirm = Yii::$app->request->post('phone-first-change-button') ? Yii::$app->request->post('phone-first-change-button') : 0;
            $add_phone_1_confirm = Yii::$app->request->post('phone-first-add-button') ? Yii::$app->request->post('phone-first-add-button') : 0;
            if ($delete_phone_1_confirm == 1) {
                $phone_del = $this->deletePhone1();
                if ($phone_del) {
                    if ($phone_del === 2) {
                          event_log2('common.contacts.php', $this->user_data['net_id'], $this->user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'],-1,-1,-1,-1,'Error delete user contact (phone number)');//функция биллинга записывает инфу в лог
                        Yii::$app->session->setFlash('phoneNotDelete', ['value' => Yii::t('flash-message', 'phone_not_delete')]);
                        return 3;
                    }

                     event_log2('common.contacts.php', $this->user_data['net_id'], $this->user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'],-1,-1,-1,-1,'Delete user contact (phone number)');//функция биллинга записывает инфу в лог
                    Yii::$app->session->setFlash('phoneFirstChangedConfirm', ['value' => Yii::t('flash-message', 'phone_1_delete')]);
                    return 2;
                }
            } elseif ($change_phone_1_confirm == 2) {
                $this->changePhone1();
            } elseif ($add_phone_1_confirm == 2) {

                $this->changePhone1();
            }

            //Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'contact_details_updated')]);
            //$this->insertNewPhone1();
            return true;
        } else {
             event_log2('common.contacts.php', $this->user_data['net_id'], $this->user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'],-1,-1,-1,-1,'Error change user contact (phone number)');//функция биллинга записывает инфу в лог
            Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'unable_change_contact')]);
            return false;
        }
    }


    public function deletePhone1()
    {
        // Debugger::PrintR($this->user_data);
        $phone_num = count($this->user_data['phone_all_array']);
        $email_num = count($this->user_data['email_array']);

        if ($phone_num > 2 || ($phone_num > 1 && $email_num > 1)) {

        } else {

            return 2;
        }

        $phone_number = Yii::$app->request->post('PhoneFirstChangeForm')['phone1'];
        turbosms_init($verbose = 1);//функция из апи биллинга, инициализирует работу с смс сообщениями
        ast_init();//функция из апи биллинга
        $normal_phone = (int)asterisk_normalize_phone($phone_number);//функция из апи биллинга, нормализирует телефон отправленный пользователем


        $user_contact_info = get_user_contacts($normal_phone, -1, -1, Yii::$app->user->id, -1, -1, -1, -1, "", -1, "", 0, PRINT_CONTACTS_GET_LIST_EX);  //получить массив контактов ($contact_info)

        del_restore_contact($user_contact_info[0][CONTACTS_RECORD_ID_IDX], 1);

         event_log2('common.contacts.php', $this->user_data['net_id'], $this->user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'], -1, -1,-1, -1, -1);//функция биллинга записывает инфу в лог

        $user_contact_info_all = get_user_contacts('', -1, -1, Yii::$app->user->id, -1, -1, -1, -1, "", -1, "", 0, PRINT_CONTACTS_GET_LIST_EX); //функция апи биллинга

        $phones_active = array();

        foreach ($user_contact_info_all as $val) {
            if ($val[CONTACTS_DEL_MARK_IDX] == 0) {
                if ($val[CONTACTS_FAST_PHONE_IDX] != 0) {
                    $phones_active[] = $val[CONTACTS_FAST_PHONE_IDX];
                }
            }
        }
        $phones_active = array_unique($phones_active);
        //  Debugger::PrintR($phones_active);
        //  Debugger::PrintR($this->user_data);
        //  Debugger::testDie();
        global $acc_db;
        global $acc_db_host;
        global $acc_db_user;
        global $acc_db_pwd;

        $update_phone_fields = new UserContactsUpdate(Yii::$app->user->id, $phones_active);

        //Debugger::PrintR($phones_active);
        //Debugger::testDie();

        // del_restore_contact($contact_id, 1); //функция биллинка - включает для сохраненного телефона пометку - ДОСТУПЕН
        //  Debugger::testDie();
        $update_phone_fields->updatePhoneFields($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);
        // $new_phones = $update_phone_fields->getNewContacts();

        return true;
    }

    public function changePhone1()
    {
        $this->addChangePhone();

        // Debugger::PrintR($this->user_data);


    }

    private function addChangePhone()
    {

        //Debugger::Eho('</br>');
        //      Debugger::Eho('</br>');
        //    Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $user_name = isset($user_data['username']) ? $user_data['username'] : '';
        $acc_id = isset($user_data['account_id']) ? $user_data['account_id'] : -1;
        $org_id = isset($user_data['org_id']) ? $user_data['org_id'] : '';

        $phone_number = Yii::$app->request->post('PhoneFirstChangeForm')['phone1'];
        Yii::$app->session->set('new_user_phone_or_email', $phone_number);

        turbosms_init($verbose = 1);//функция из апи биллинга, инициализирует работу с смс сообщениями
        ast_init();//функция из апи биллинга
        $normal_phone = asterisk_normalize_phone($phone_number);//функция из апи биллинга, нормализирует телефон отправленный пользователем
        $this->normal_phone = $normal_phone;


        Yii::$app->session->set('normal_phone', $normal_phone);


        // Debugger::Eho('</br>');
        // Debugger::Eho('</br>');
        //Debugger::Eho($phone_number);
        //Debugger::Eho('</br>');
        //Debugger::Eho($normal_phone);
        // Debugger::Eho('</br>');


        // Debugger::Eho('</br>');
        //Debugger::Eho('its work');
        $number_valid = ast_get_sms_route($normal_phone, 1);
        Yii::$app->session->set('number_valid', $number_valid);
        //   Debugger::Eho($number_valid);
        //  Debugger::testDie();
        if ($number_valid !== -1) { //функция из апи биллинга, проверяет номер на возможность отправки смс.
            $user_sms = new UserSms(Yii::$app->language);
            $sms_text = Yii::t('sms_messages', 'change_password');
            $full_sms_text = $user_sms->createSmsTextPasswordChange(
                $sms_text,
                Yii::$app->params['sms_send_conf']['transliteration'],
                Yii::$app->params['sms_send_conf']['verification_cod_length'],
                Yii::$app->params['sms_send_conf']['verification_cod_num'],
                Yii::$app->params['sms_send_conf']['verification_cod_down_chars'],
                Yii::$app->params['sms_send_conf']['verification_cod_up_chars']
            );
            // Debugger::Eho($normal_phone);
            // Debugger::Eho('</br>');
            // Debugger::Eho($full_sms_text);
            // Debugger::Eho('</br>');
            // Debugger::Eho($org_id);
            // Debugger::Eho('</br>');
            // Debugger::Eho($acc_id);
            // Debugger::testDie();
            global $acc_db_host;
            global $acc_db;
            global $acc_db_user;
            global $acc_db_pwd;

            $sms_statistics = new SmsStatistics($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);
            $sms_statistics->deleteOld(Yii::$app->params['sms_time_limit_delete']);
            if ($sms_statistics->smsLimit(Yii::$app->user->id, Yii::$app->params['sms_time_limit'], Yii::$app->params['sms_limit'])) {
                turbosms_send($normal_phone, $full_sms_text, $org_id, 0, $acc_id); //Открпвка смс, функция биллинга
                $sms_statistics->insertData(Yii::$app->user->id);
            } else {
                Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'limit_sms_send')]);
                return false;
            }
        } else {
            //создается туду на перезвон пользователю
            global $todo_ctx;
            //User::UserData();


            $todo_ctx = array(
                "subj" => transcode_utf8_to_internal('Обращение в тех-поддержку') . ' user: ' . $user_name . ', ' . transcode_utf8_to_internal('запрос call-back для подтверждения изменения (добавления) нового телефона в контакты пользователя'),
                "ref_acc_id" => $acc_id,
                "todo_desc" => transcode_utf8_to_internal("Перезвоните мне на номер ") . $phone_number . transcode_utf8_to_internal(' для подтверждения работоспособности этого номера и сохранения его в моей контактной информации.'),  //  transcode_utf8_to_internal("(TEST)Перезвоните мне на номер").$phone_number,  // iconv_safe('utf-8','koi8-u',  "(TEST)Перезвоните мне на номер").$phone_number,
                "todo_type" => TODO_SUPPORT,
                "todo_state" => REQ_TYPE_CALL,
                "exec_list" => "@duty",

            );

            new_todo_simple(0, TODO_SUPPORT, $todo_ctx,
                -1, $acc_id, -1);
        }


    }

}