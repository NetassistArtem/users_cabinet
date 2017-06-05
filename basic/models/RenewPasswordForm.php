<?php

namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use app\components\sms_handler\UserSms;
use app\components\user_contacts_update\UserContactsUpdate;
use app\components\user_contacts_update\SmsStatistics;

/**
 * ContactForm is the model behind the contact form.
 */
class RenewPasswordForm extends Model
{
    public $email;
    public $phone;

    /**
     * @return array the validation rules.
     */


    public function rules()
    {
        return [
            // name, email, subject and body are required
            // email has to be a valid email address

            [['phone', 'email'], 'trim'],
            [['email'], 'email'],
            ['phone', 'match', 'pattern' => '/^((\+380)(\s?\(?\d{2})\)\s?)(\d{3})(\s?\d{2})(\s?\d{2})$/', 'message' => Yii::t('flash-message', 'incorrect_telephone')],
            [['phone', 'email'], 'default', 'value' => '-1'],
            [['email', 'phone'], 'require_all']
            // verifyCode needs to be entered correctly
            //    ['verifyCode', 'captcha'],
        ];
    }

    public function require_all($attribute)
    {

        if ($this->email == -1 && $this->phone == -1) {


            $this->phone = '';
            $this->email = '';

            $this->addError($attribute, Yii::t('renew_password', 'not_all_empty'));

            return false;

        }

        $this->phone = $this->phone == -1 ? '' : $this->phone;
        $this->email = $this->email == -1 ? '' : $this->email;

        return true;

    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            //   'verifyCode' => 'Verification Code',
        ];
    }

    public function findUser($txt)
    {
        $flags = PRINT_CONTACTS_GET_LIST_EX;
        //  $flags = PRINT_CONTACTS_GET_LIST;
        // $flags = OPT_VERBOSE;

        return find_contacts($txt, $flags);
    }

    public function sendNewPasswordCode()
    {

        if ($this->validate()) {
            return $this->FindUserByContact($this->email, $this->phone);
        }
    }

    private function FindUserByContact($email, $phone)
    {
        $email_phone = '';
        if ($email && $phone) {
            $phone = '';
            $email_phone = 1;
        }

        $contact_info = array();
        $contact_id_array = array();

        if ($email) {
            $contact_id_array = $this->findUser($email);


        } elseif ($phone) {
            $search = array('+','*','(',')',' ', '-', '_','/');
            $phone = str_replace($search,'', $phone);


            $contact_id_array = $this->findUser($phone);

        }

        if (!empty($contact_id_array)) {

            foreach ($contact_id_array as $k => $v) {
                $c_i = get_contact_info($k);

                if ($c_i[CONTACTS_DEL_MARK_IDX] != 1 && $c_i[CONTACTS_USER_IDX] != -1) {
                    $user_data = get_user_info_by_ids($c_i[CONTACTS_USER_IDX]);
                    if ($user_data[UINFO_DEL_MARK_IDX] != 1) {

                        $contact_info[] = get_contact_info($k);
                    }
                }


            }


            if (!empty($contact_info)) {

                if (count($contact_info) > 1) {

                    $new_contact_info[] = $contact_info[0];
                    foreach ($contact_info as $key => $val) {

                        if ($val[CONTACTS_USER_IDX] != $new_contact_info[0][CONTACTS_USER_IDX]) {

                            $new_contact_info[] = $val;
                        }
                    }
                    if (count($new_contact_info) > 1) {
                        if ($email_phone) {
                            $this->FindUserByContact('', $this->phone);
                        }

                        Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'try_other_email_phone ')]);
                        //значит есть два разных USER_id с одним и тем же контактом
                        return 2;
                    }
                }

                if ($email) {

                    $this->sendEmailConfirm();
                    Yii::$app->session->set('renew_password_email', $email);
                    Yii::$app->session->set('username_password_renew', $contact_info[0][CONTACTS_NICK_IDX]);


                    return 'email';


                } elseif ($phone) {
                    if($this->sendSmsConfirm($contact_info[0][CONTACTS_USER_IDX])){
                        Yii::$app->session->set('renew_password_phone', $phone);
                        Yii::$app->session->set('username_password_renew', $contact_info[0][CONTACTS_NICK_IDX]);
                        Yii::$app->session->set('userid_password_renew', $contact_info[0][CONTACTS_USER_IDX]);
                        return 'phone';
                    }else{
                        return 2;
                    }



                } else {
                    return 2;
                }

            } else {
                if ($email_phone) {
                    //  $this->FindUserByContact('',$this->phone);
                }
                Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'old_data_get_new_data')]);
                return 2;

            }

        } else {
            if ($email_phone) {
                //   $this->FindUserByContact('',$this->phone);
            }
            Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'user_with_this_contact_absent')]);
            return 2;
        }
    }

    public function sendEmailConfirm()
    {
        $user_email = new UserSms(Yii::$app->language);
        $email_text = Yii::t('sms_messages', 'renew_password_code_confirm');
        $full_email_text = $user_email->createSmsTextPasswordChange(
            $email_text,
            Yii::$app->params['email_send_conf_renew_pass']['transliteration'],
            Yii::$app->params['email_send_conf_renew_pass']['verification_cod_length'],
            Yii::$app->params['email_send_conf_renew_pass']['verification_cod_num'],
            Yii::$app->params['email_send_conf_renew_pass']['verification_cod_down_chars'],
            Yii::$app->params['email_send_conf_renew_pass']['verification_cod_up_chars']
        );
        $subject = Yii::t('sms_messages', 'subject_renew_password_code_confirm');
        global $_admin_mail;
        $from_mail = $_admin_mail;
        $server_name = Yii::$app->params['server_name'];
        $domains_key = Yii::$app->params['domains'][$server_name];
        $from_user = Yii::t('site', 'admin') . Yii::t('site', Yii::$app->params['sites_data'][$domains_key]['company_name']['lang_key']);

        // Debugger::Eho($normal_phone);
        // Debugger::Eho('</br>');
        // Debugger::Eho($full_sms_text);
        // Debugger::Eho('</br>');
        // Debugger::Eho($org_id);
        // Debugger::Eho('</br>');
        // Debugger::Eho($acc_id);
        // Debugger::EhoBr($full_email_text);


        // turbosms_send($normal_phone, $full_sms_text, $org_id, 0, $acc_id); //Открпвка смс, функция биллинга
        my_mail($this->email, iconv_safe('utf-8', 'koi8-u', $full_email_text), iconv_safe('utf-8', 'koi8-u', $subject), $from_mail, $from_user);
        //  Debugger::testDie();
        Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'send_code_by_email')]);
    }


    public function sendSmsConfirm($user_id)
    {
        // $phone_number = Yii::$app->request->post('PhoneAddForm')['phone1'];
        //  Yii::$app->session->set('add', 1);
        //  Yii::$app->session->set('new_user_phone_or_email', $phone_number);

        turbosms_init($verbose = 1);//функция из апи биллинга, инициализирует работу с смс сообщениями
        ast_init();//функция из апи биллинга
        $normal_phone = asterisk_normalize_phone($this->phone);//функция из апи биллинга, нормализирует телефон отправленный пользователем
        // Yii::$app->session->set('normal_phone', $normal_phone);

        // Debugger::Eho('</br>');
        // Debugger::Eho('</br>');
        //Debugger::Eho($phone_number);
        //Debugger::Eho('</br>');
        //Debugger::Eho($normal_phone);
        // Debugger::Eho('</br>');


        // Debugger::Eho('</br>');
        //Debugger::Eho('its work');
        $number_valid = ast_get_sms_route($normal_phone, 1);
        //  Yii::$app->session->set('number_valid', $number_valid);
        //   Debugger::Eho($number_valid);
        //  Debugger::testDie();
        if ($number_valid !== -1) { //функция из апи биллинга, проверяет номер на возможность отправки смс.
            $user_sms = new UserSms(Yii::$app->language);
            $sms_text = Yii::t('sms_messages', 'renew_password_code_confirm_sms');
            $full_sms_text = $user_sms->createSmsTextPasswordChange(
                $sms_text,
                Yii::$app->params['sms_send_conf_renew_pass']['transliteration'],
                Yii::$app->params['sms_send_conf_renew_pass']['verification_cod_length'],
                Yii::$app->params['sms_send_conf_renew_pass']['verification_cod_num'],
                Yii::$app->params['sms_send_conf_renew_pass']['verification_cod_down_chars'],
                Yii::$app->params['sms_send_conf_renew_pass']['verification_cod_up_chars']
            );
            //  Debugger::Eho($normal_phone);
            //  Debugger::Eho('</br>');
            //  Debugger::Eho($full_sms_text);
            //  Debugger::Eho('</br>');
            //  Debugger::Eho($org_id);
            //  Debugger::Eho('</br>');
            //  Debugger::Eho($acc_id);
            //  Debugger::testDie();
            global $acc_db_host;
            global $acc_db;
            global $acc_db_user;
            global $acc_db_pwd;

            $sms_statistics = new SmsStatistics($acc_db_host, $acc_db, $acc_db_user, $acc_db_pwd);
            $sms_statistics->deleteOld(Yii::$app->params['sms_time_limit_delete']);
            $sms_limit = Yii::$app->params['sms_limit_pass_renew'] - 1; //меньше на 1 так как надо еще сообщение для отправки собственно пароля
            if ($sms_statistics->smsLimit($user_id, Yii::$app->params['sms_time_limit'], $sms_limit)) {
                //$normal_phone
                turbosms_send($normal_phone, $full_sms_text, ''); //Открпвка смс, функция биллинга
                $sms_statistics->insertData($user_id);
            } else {
                Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'limit_sms_send')]);
                return false;
            }

            Yii::$app->session->setFlash('renewPassword', ['value' => Yii::t('flash-message', 'send_code_by_phone')]);
            return true;

        } else {
            return false;
        }
    }


    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */

}