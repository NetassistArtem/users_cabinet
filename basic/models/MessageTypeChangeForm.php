<?php


namespace app\models;


use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;


class MessageTypeChangeForm extends Model
{

    public $emailMessage;

    public $smsMessage;

    public $telegramMessage;

    public $messageLang;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [







        ];
    }

    public function setNewMessageType()
    {

        if($this->validate()) {


           $this->insertNewMessageType();

           // die();

            Yii::$app->session->setFlash('messageTypeChanged', ['value' => Yii::t('flash-message', 'notification_settings_saved')]);

        //    Yii::$app->session->set('selected_options', );



            return true;
        }else {


            Yii::$app->session->setFlash('messageTypeChanged', ['value' => Yii::t('flash-message', 'notification_settings_not_saved')]);
            return false;
        }
    }

    public function insertNewMessageType()
    {
        $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];




        $post_data = Yii::$app->request->post('MessageTypeChangeForm');
        $this->setNewMessageLang($user_data, $post_data);

        $selected_array = array();
        if(is_array($post_data['emailMessage'])){
            foreach($post_data['emailMessage'] as $k => $v){
                $selected_array['email'][] = $v;
            }
        }
        if(is_array($post_data['smsMessage'])){
            foreach($post_data['smsMessage'] as $k => $v){
                $selected_array['sms'][] = $v;
            }
        }
        if(is_array($post_data['telegramMessage'])){
            foreach($post_data['telegramMessage'] as $k => $v){
                $selected_array['telegram'][] = $v;
            }
        }



       // $user_data = Yii::$app->session->get('user-data')[Yii::$app->user->id];

        foreach($user_data['email_message_type_all'] as $k => $v){
            if($k != 0){
                if(is_array($post_data['emailMessage'])){
                    if(array_search($k,$post_data['emailMessage']) !== false){
                        $_POST[$v[0]] = 1;
                    }
                }


            }
        }
        foreach($user_data['sms_message_type_all'] as $k => $v){
            if($k != 0){
                if(is_array($post_data['smsMessage'])){
                    if(array_search($k,$post_data['smsMessage']) !== false){
                        $_POST[$v[0]] = 1;
                    }
                }


            }
        }
        foreach($user_data['telegram_message_type_all'] as $k => $v){
            if($k != 0){
                if(is_array($post_data['telegramMessage'])){
                    if(array_search($k,$post_data['telegramMessage']) !== false){
                        $_POST[$v[0]] = 1;
                    }
                }


            }
        }






        if(!$user_data['telegram_info']){
            unset($_POST['MessageTypeChangeForm']['telegramMessage']);
        }
        $request_vars = $_POST;



        //Debugger::PrintR($request_vars);

       $sm_flags = get_sm_options($request_vars, $input_name="sm_flag");

      //  Debugger::EhoBr($sm_flags);
        //Debugger::testDie();
        apply_sm_flags($user_data['account_id'], $sm_flags);

        event_log2('common.user.opt.inc.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $user_data['loc_id'], -1, -1,-1,-1, 'Change sm options');//функция биллинга записывает инфу в лог

        Yii::$app->session->set('selected_options',$selected_array );


        return '';
    }

    public function setNewMessageLang($user_data,$post_data){
        $billing_lang_id = Yii::$app->params['lang'][$post_data['messageLang']]['id_billing'];
     //   Debugger::EhoBr($post_data['messageLang']);
     //   Debugger::VarDamp($billing_lang_id);
       // Debugger::EhoBr($user_data['message_lang']);

        if($user_data['message_lang_billing_id'] != $billing_lang_id ){

            set_skin_lang("*".$user_data['account_name'],$billing_lang_id);//функция биллинга, устанавливает язык рассылки
           // Debugger::EhoBr(get_skin_lang("*".$user_data['account_name']));
         //   Debugger::testDie();
            ast_init();
            ast_upd_contact_classes(0, $billing_lang_id, $user_data['account_id'],0,0);//функция биллинка, установливает язык голосовых сообщений
           // Debugger::testDie();
            event_log2('common.lang.php', $user_data['net_id'], $user_data['account_id'], Yii::$app->user->id, -1, $user_data['loc_id'], -1, -1,-1,-1, 'Change message lang');//функция биллинга записывает инфу в лог
        }
    }

}