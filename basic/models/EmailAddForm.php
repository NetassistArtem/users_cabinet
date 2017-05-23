<?php


namespace app\models;


use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use yii\web\Controller;
use app\components\sms_handler\UserSms;

class EmailAddForm extends Model
{

    public $email;
    public $user_data;

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

            $this->addNewEmail();
           // Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'contact_details_updated')]);
            //$this->insertNewPhone1();
            return true;
        } else {
            Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'unable_change_contact')]);
            return false;
        }
    }

    public function addNewEmail()
    {
        $this->addChangeEmail();

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
        //$popap_controller = new PopapController();
        $email = Yii::$app->request->post('EmailAddForm')['email'];
        Yii::$app->session->set('add', 1);
        Yii::$app->session->set('new_user_phone_or_email', $email);

            $user_email = new UserSms(Yii::$app->language);
            $email_text = Yii::t('sms_messages', 'change_email');
            $full_email_text = $user_email->createSmsTextPasswordChange(
                $email_text,
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

        // Debugger::Eho($normal_phone);
            // Debugger::Eho('</br>');
            // Debugger::Eho($full_sms_text);
            // Debugger::Eho('</br>');
            // Debugger::Eho($org_id);
            // Debugger::Eho('</br>');
            // Debugger::Eho($acc_id);
       // Debugger::EhoBr($full_email_text);


            // turbosms_send($normal_phone, $full_sms_text, $org_id, 0, $acc_id); //Открпвка смс, функция биллинга
        my_mail( $email, iconv_safe('utf-8','koi8-u',$full_email_text), iconv_safe('utf-8','koi8-u',$subject), $from_mail, $from_user);
      //  Debugger::testDie();
    }

}