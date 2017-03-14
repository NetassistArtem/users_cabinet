<?php


namespace app\models;


use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use yii\web\Controller;
use app\components\sms_handler\UserSms;
use app\components\user_contacts_update\UserContactsUpdate;

class EmailChangeForm extends Model
{

    public $email;
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

            [['email'], 'required'],
            [['email'], 'trim'],
            [['email'], 'email'],
        ];
    }

    public function setNewEmail()
    {
        // $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];


        if ($this->validate()) {
            $delete_email_confirm = Yii::$app->request->post('email-delete-button') ? Yii::$app->request->post('email-delete-button') : 0;
            $change_email_confirm = Yii::$app->request->post('email-change-button') ? Yii::$app->request->post('email-change-button') : 0;
            $add_email_confirm = Yii::$app->request->post('email-add-button') ? Yii::$app->request->post('email-add-button') : 0;
            if ($delete_email_confirm == 1) {
                $email_del = $this->deleteEmail();
                if ($email_del) {
                    if ($email_del === 2) {

                        Yii::$app->session->setFlash('emailNotDelete', ['value' => Yii::t('flash-message', 'email_not_delete')]);
                        return 3;
                    }


                    Yii::$app->session->setFlash('phoneFirstChangedConfirm', ['value' => Yii::t('flash-message', 'email_delete')]);
                    return 2;
                }
            } elseif ($change_email_confirm == 2) {
                $this->changeEmail();
            } elseif ($add_email_confirm == 2) {

                $this->changeEmail();
            }

            //Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'contact_details_updated')]);
            //$this->insertNewPhone1();
            return true;
        } else {
            Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'unable_change_contact')]);
            return false;
        }
    }


    public function deleteEmail()
    {
       // Debugger::PrintR($this->user_data);
        $phone_num = count($this->user_data['phone_all_array']);
        $email_num = count($this->user_data['email_array']);

        if ($email_num > 2 || ($phone_num > 1 && $email_num > 1)) {

        } else {

            return 2;
        }

        $email = Yii::$app->request->post('EmailChangeForm')['email'];


        $user_contact_info = get_user_contacts('', -1, -1, Yii::$app->user->id, -1, -1, -1, -1, "", -1, "", 0, PRINT_CONTACTS_GET_LIST_EX);  //получить массив контактов ($contact_info)

        $contact_id = '';

        foreach ($user_contact_info as $value) {
            if ($value[CONTACTS_EMAIL_IDX] == $email) {
                $contact_id = $value[CONTACTS_RECORD_ID_IDX];
            }
        }


        del_restore_contact($contact_id, 1);//функция апи биллинга

        event_log('common.contacts.php', $this->user_data['net_id'], $this->user_data['account_id'], Yii::$app->user->id, -1, $this->user_data['loc_id'], -1, -1, -1);//функция биллинга записывает инфу в лог

        $user_contact_info_all = get_user_contacts('', -1, $this->user_data['account_id'], -1, -1, -1, -1, -1, "", -1, "", 0, PRINT_CONTACTS_GET_LIST_EX); //функция апи биллинга

        $email_active = array();

        foreach ($user_contact_info_all as $val) {
            if ($val[CONTACTS_DEL_MARK_IDX] == 0) {
                if ($val[CONTACTS_EMAIL_IDX]) {
                    $email_active[] = $val[CONTACTS_EMAIL_IDX];
                }

            }
        }
        $email_active = array_unique($email_active);
        //  Debugger::PrintR($phones_active);
        //  Debugger::PrintR($this->user_data);
        //  Debugger::testDie();
        global $acc_db;
        global $acc_db_host;
        global $acc_db_user;
        global $acc_db_pwd;

        $update_emails_fields = new UserContactsUpdate(Yii::$app->user->id,array(),$email_active );

        //Debugger::PrintR($phones_active);
        //Debugger::testDie();

        // del_restore_contact($contact_id, 1); //функция биллинка - включает для сохраненного телефона пометку - ДОСТУПЕН
        //  Debugger::testDie();
        $update_emails_fields->updateEmailFields($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);

        return true;
    }

    public function changeEmail()
    {
        $this->addChangeEmail();

        // Debugger::PrintR($this->user_data);


    }

    private function addChangeEmail()
    {

        //Debugger::Eho('</br>');
        //      Debugger::Eho('</br>');
        //    Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');

        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];
        $user_name = isset($user_data['username']) ? $user_data['username'] : '';
        $acc_id = isset($user_data['account_id']) ? $user_data['account_id'] : -1;
        $org_id = isset($user_data['org_id']) ? $user_data['org_id'] : '';

        $email = Yii::$app->request->post('EmailChangeForm')['email'];
        Yii::$app->session->set('new_user_phone_or_email', $email);

            $user_message = new UserSms(Yii::$app->language);
        $message_text = Yii::t('sms_messages', 'change_password');
            $full_message_text = $user_message->createSmsTextPasswordChange(
                $message_text,
                Yii::$app->params['email_send_conf']['transliteration'],
                Yii::$app->params['email_send_conf']['verification_cod_length'],
                Yii::$app->params['email_send_conf']['verification_cod_num'],
                Yii::$app->params['email_send_conf']['verification_cod_down_chars'],
                Yii::$app->params['email_send_conf']['verification_cod_up_chars']
            );
        $subject = Yii::t('sms_messages', 'subject');
        global $_admin_mail;
        $from_mail = $_admin_mail;
        $server_name = Yii::$app->params['server_name'];
        $domains_key = Yii::$app->params['domains'][$server_name];
        $from_user = Yii::t('site','admin') . Yii::t('site', Yii::$app->params['sites_data'][$domains_key]['company_name']['lang_key']);
          //   Debugger::Eho(Yii::$app->params['sites_data'][$domains_key]['company_name']['lang_key']);
            // Debugger::Eho('</br>');
           //  Debugger::Eho($server_name);
           //  Debugger::Eho('</br>');

          //   Debugger::Eho('</br>');
          //   Debugger::Eho($from_mail);
          //  Debugger::testDie();

            //  turbosms_send($normal_phone, $full_sms_text, $org_id, 0, $acc_id); //Открпвка смс, функция биллинга

        my_mail( $email, $full_message_text, $subject, $from_mail, $from_user);

    }

}