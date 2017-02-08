<?php


namespace app\models;


use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use yii\web\Controller;
use app\components\sms_handler\UserSms;

class PhoneFirstChangeForm extends Model
{

    public $phone1;
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

            [['phone1'], 'trim'],




        ];
    }

    public function setNewPhone1()
    {
       // $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];


        if ($this->validate()) {
            $delete_phone_1_confirm = Yii::$app->request->post('phone-first-delete-button') ? Yii::$app->request->post('phone-first-delete-button') : 0;
            $change_phone_1_confirm = Yii::$app->request->post('phone-first-change-button') ? Yii::$app->request->post('phone-first-change-button') : 0;
            $add_phone_1_confirm = Yii::$app->request->post('phone-first-add-button') ? Yii::$app->request->post('phone-first-add-button') : 0;
            if($delete_phone_1_confirm == 1){
                if($this->deletePhone1()){
                   // Debugger::Eho($delete_phone_1_confirm);

                    Yii::$app->session->setFlash('phoneDeleteChanged', ['value' => Yii::t('flash-message', 'phone_1_delete')]);
               return 2;
                }
            }elseif($change_phone_1_confirm == 2){
                $this->changePhone1();
            }elseif($add_phone_1_confirm == 3){

                $this->changePhone1();
            }

            //Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'contact_details_updated')]);
            //$this->insertNewPhone1();
            return true;
        } else {
            Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'unable_change_contact')]);
            return false;
        }
    }

    public function addNewPhone1()
    {
        $this->addChangePhone();

        return '';
    }

    public function deletePhone1()
    {
        return true;
    }

    public function changePhone1()
    {
        $this->addChangePhone();

       // Debugger::PrintR($this->user_data);



        $user_phone_new = Yii::$app->request->post('PhoneFirstChangeForm')['phone1'];
        $user_phone_old = Yii::$app->session->get('phone_to_change');



        $user_contact_info = get_user_contacts("", -1, -1, Yii::$app->user->id, -1,-1, -1,-1,"",-1,"",0, PRINT_CONTACTS_SHOW_SINGLE_ROW);  //получить массив контактов ($contact_info)

        Debugger::PrintR($user_contact_info);
        Debugger::testDie();

        update_user_contacts( Yii::$app->request->post('PhoneFirstChangeForm')['phone1'],  //функция апи биллинга
            CONTACT_USER.",".CONTACT_REQ, CONTACT_USER, "", 0, UNDEL_CONTACT,
            $this->user_data['username'],$this->user_data['real_name'],$this->user_data['address'],$this->user_data['account_id'],Yii::$app->user->id,$this->user_data['net_id'], $this->user_data['loc_id'], $this->user_data['req_id'], "",-1);


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
        //$popap_controller = new PopapController();
        $phone_number = Yii::$app->request->post('PhoneFirstChangeForm')['phone1'];
        Yii::$app->session->set('new_user_phone_or_email',$phone_number);

        turbosms_init($verbose=1);//функция из апи биллинга, инициализирует работу с смс сообщениями
        ast_init();//функция из апи биллинга
        $normal_phone = asterisk_normalize_phone($phone_number);//функция из апи биллинга, нормализирует телефон отправленный пользователем


       // Debugger::Eho('</br>');
       // Debugger::Eho('</br>');
        //Debugger::Eho($phone_number);
         //Debugger::Eho('</br>');
        //Debugger::Eho($normal_phone);
        // Debugger::Eho('</br>');


        // Debugger::Eho('</br>');
        //Debugger::Eho('its work');
        $number_valid = ast_get_sms_route($normal_phone, 1);
        Yii::$app->session->set('number_valid',$number_valid);
        //   Debugger::Eho($number_valid);
         //  Debugger::testDie();
        if($number_valid !== -1){ //функция из апи биллинга, проверяет номер на возможность отправки смс.
            $user_sms = new UserSms(Yii::$app->language);
            $sms_text = Yii::t('sms_messages','change_password');
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

           // turbosms_send($normal_phone, $full_sms_text, $org_id, 0, $acc_id); //Открпвка смс, функция биллинга
        }else{
            //создается туду на перезвон пользователю
            global $todo_ctx;
            //User::UserData();




            $todo_ctx = array(
                "subj" => transcode_utf8_to_internal('Обращение в тех-поддержку').' user: '. $user_name. ', ' .transcode_utf8_to_internal('запрос call-back для подтверждения изменения (добавления) нового телефона в контакты пользователя'),
                "ref_acc_id" => $acc_id,
                "todo_desc" =>  transcode_utf8_to_internal("Перезвоните мне на номер ").$phone_number. transcode_utf8_to_internal(' для подтверждения работоспособности этого номера и сохранения его в моей контактной информации.'),  //  transcode_utf8_to_internal("(TEST)Перезвоните мне на номер").$phone_number,  // iconv_safe('utf-8','koi8-u',  "(TEST)Перезвоните мне на номер").$phone_number,
                "todo_type" => TODO_SUPPORT,
                "todo_state" => REQ_TYPE_CALL,
                "exec_list" => "@duty",

            );

          //  new_todo_simple(0, TODO_SUPPORT, $todo_ctx,
          //      -1, $acc_id, -1);
        }


        // Debugger::Eho($full_sms_text);




        //  Debugger::PrintR($_SESSION);
        //  Debugger::testDie();

        // Yii::$app->getResponse()->redirect('/phone-first-change-confirm');

        //  PopapController::actionPhoneFirstChangeConfirm(Yii::$app->request->post('PhoneFirstChangeForm')['phone1']);
        //  Yii::$app->session->setFlash('phoneFirstChanged', ['value' => Yii::t('flash-message', 'delete')]);

        // return '';
    }

}