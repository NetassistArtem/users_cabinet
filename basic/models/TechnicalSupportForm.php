<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;

class TechnicalSupportForm extends Model
{

    public $sup_class;
    //public $oldPasswordRepeat;
    public $problem_appeared;
    public $os_type;
    public $avir_present;
    public $change_avir;
    public $low_speed;
    public $router_present;
    public $change_pc;
    public $user_wifi_link;
    public $direct_link_ok;
    public $low_speed_direct;
    public $user_reboot;
    public $user_wifi_reboot;
    public $user_wifi_wan;
    public $todo_desc;
    public $import_file_name;
    public $user_speed;
    public $new_equipment;
    public $unavailable_sites;
    public $available_sites;
    public $unavailable_site;
    public $ping_answer;
    public $dns;
    public $renew_os;

    public $files;
    public $y1;
    public $m1;
    public $d1;
    public $h1;
    public $mn1;
    public $exec_list;
    public $sv_list;
    public $rsp_admin_id;
    public $severity;
    public $subj;
    public $user_net_id;
    public $todo_type;
    public $ref_acc_id;
    public $orig_ref_acc_id;
    public $orig_todo_state;
    public $ref_req_id;
    public $orig_origin_todo_id;
    public $origin_todo_id;
    public $ref_loc_id;
    public $call_support;
    public $user_name;
    public $sub_todo_id;
    public $last_ver;
    public $orig_admin_id;
    public $orig_hide_mask;
    public $hw_fault_hash_orig;
    public $night_work0;
    public $complexity0;
    public $next_serial;
    public $edit_req;
    public $todo_id;

    public $problem_type;
    public $connect_type;
    public $user_network_cart_indication;
    public $comp_ip;

    // private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [[
                'sup_class',
                'problem_appeared',
                'os_type',
                'avir_present',
                'change_avir',
                'low_speed',
                'router_present',
                'change_pc',
                'user_wifi_link',
                'direct_link_ok',
                'low_speed_direct',
                'user_reboot',
                'user_wifi_reboot',
                'user_wifi_wan',
                'todo_desc',
                'import_file_name',
                'comp_ip',
                'unavailable_sites',
                'unavailable_site',
                'available_sites',
                'ping_answer',
                'dns',
            ], 'trim'],
            ['import_file_name', 'file', 'extensions' => ['png', 'jpg', 'gif','tiff','pdf','obt','doc','docs','txt'], 'maxFiles' =>4, 'maxSize' => 1024*1024*3],
[['todo_desc', 'problem_appeared', 'avir_present', 'comp_ip', 'unavailable_sites', 'available_sites','unavailable_site', 'ping_answer','dns'],'filter','filter' => function($value){
    strip_tags($value);
    return $value;
}],
            [['problem_appeared', 'avir_present',], 'string'],
            [['low_speed_direct','low_speed'], 'number']


        ];
    }

    public function sendTechnicalInfo()
    {
        if ($this->validate()) {
            $this->insertTechnicalInfo();
            Yii::$app->session->setFlash('TechnicalInfo', ['value' => Yii::t('flash-message', 'request_sent_support')]);

            return true;
        } else {
            Yii::$app->session->setFlash('TechnicalInfo', ['value' => Yii::t('flash-message', 'unable_send_data')]);
            return false;
        }
    }

    public function insertTechnicalInfo()
    {


        global $request_vars;
       // global $opt_vars;
        global $todo_ctx;



        User::UserData();
        $send_data = Yii::$app->request->post('TechnicalSupportForm');
        $acc_id = isset($send_data['ref_acc_id']) ? $send_data['ref_acc_id'] : -1;


        $problem_date = $send_data['problem_appeared'] ? $send_data['problem_appeared'] : 'Нет данных';
        $description = $send_data['todo_desc'] ? $send_data['todo_desc'] : 'Нет данных';

        $text_data = 'Характер проблемы: <b>' .Yii::$app->params['problem_types'][$send_data['problem_type']][0] . '</b></br>';
        if($send_data['problem_type'] != 8){
            $text_data .= 'Когда началось: <b>'.$problem_date.'</b></br>';
        }

        if($send_data['problem_type'] == 2){
            $connect_type = Yii::$app->params['net_connection_type'][$send_data['connect_type']][0];
            $ip_comp = $send_data['comp_ip'] ? $send_data['comp_ip'] : 'Нет данных';
            $text_data .= 'Подключен к сети: <b>'.$connect_type.'</b></br>';
            $text_data .= 'Индикация роутера: <b>'.Yii::$app->params['short_answer'][$send_data['user_wifi_wan']][0].'</b></br>';
            $text_data .= 'Перезагрузка роутера: <b>'.Yii::$app->params['short_answer'][$send_data['user_wifi_reboot']][0].'</b></br>';
            $text_data .= 'Индикация сетевой карты: <b>'.Yii::$app->params['short_answer'][$send_data['user_network_cart_indication']][0].'</b></br>';
            $text_data .= 'Пользователь получает IP: <b>'.$ip_comp.'</b></br>';
        }
        if($send_data['problem_type'] == 3){
            $connect_type = Yii::$app->params['net_connection_type'][$send_data['connect_type']][0];
            $user_speed = $send_data['user_speed'] != 0?  Yii::$app->params['user_speed'][$send_data['user_speed']][0] : "Нет данных";
            $text_data .= 'Подключен к сети: <b>'.$connect_type.'</b></br>';
            $text_data .= 'Показания скорости: <b>'.$user_speed.'</b></br>';
            $text_data .= 'Перезагрузка роутера: <b>'.Yii::$app->params['short_answer'][$send_data['user_wifi_reboot']][0].'</b></br>';
        }
        if($send_data['problem_type'] == 4){
            $ip_comp = $send_data['comp_ip'] ? $send_data['comp_ip'] : 'Нет данных';
            $connect_type = Yii::$app->params['net_connection_type'][$send_data['connect_type']][0];
            $text_data .= 'Подключение нового оборудования: <b>'.Yii::$app->params['short_answer'][$send_data['new_equipment']][0].'</b></br>';
            $text_data .= 'Подключен к сети: <b>'.$connect_type.'</b></br>';
            $text_data .= 'Пользователь получает IP: <b>'.$ip_comp.'</b></br>';
        }
        if($send_data['problem_type'] == 5){
            $unavailable_sites = $send_data['unavailable_sites'] ? $send_data['unavailable_sites'] : 'Нет данных';
            $available_sites = $send_data['available_sites'] ? $send_data['available_sites'] : 'Нет данных';
            $text_data .= 'Подключение нового оборудования: <b>'.Yii::$app->params['short_answer'][$send_data['new_equipment']][0].'</b></br>';
            $text_data .= 'Доступные ресурсы: <b>'.$available_sites.'</b></br>';
            $text_data .= 'Недооступные ресурсы: <b>'.$unavailable_sites.'</b></br>';
        }
        if($send_data['problem_type'] == 6){
            $unavailable_site = $send_data['unavailable_site'] ? $send_data['unavailable_site'] : 'Нет данных';
            $dns = $send_data['dns'] ? $send_data['dns'] : 'Нет данных';
            $text_data .= 'Недооступный ресурс: <b>'.$unavailable_site.'</b></br>';
            $text_data .= 'Ответ на пинг ресурса: <b>'.Yii::$app->params['short_answer'][$send_data['ping_answer']][0].'</b></br>';
            $text_data .= 'DNS указанный в настройках: <b>'.$dns.'</b></br>';
        }
        if($send_data['problem_type'] == 7){
            $os = get_lang_opt_list('os_types'); //функция из api биллинга
            $operation_systems = $send_data['os_type'] == 0 ? 'Нет данных' : $os[$send_data['os_type']];
            $text_data .= 'Операционная система: <b>'.$operation_systems.'</b></br>';
            $text_data .= 'Обновление операционной системы: <b>'.Yii::$app->params['short_answer'][$send_data['renew_os']][0].'</b></br>';
            $text_data .= 'Устонавливали или обновляли антивирус: <b>'.Yii::$app->params['short_answer'][$send_data['change_avir']][0].'</b></br>';
        }
        $text_data .= 'Сообщение пользователя: </br>';
        $text_data .= '<b>'.$description.'</b></br>';

        $new_ctx = array(
            "subj" => transcode_utf8_to_internal($send_data['subj']),// iconv_safe('utf-8','koi8-u',  $send_data['subj']),
          //  "ref_acc_id" => $acc_id,
            "todo_desc" => transcode_utf8_to_internal($text_data),// iconv_safe('utf-8','koi8-u',  $send_data['todo_desc']),
          //  "todo_type" => $send_data['todo_type'],
          //  "exec_list" => $send_data['exec_list'],

        );
      // Debugger::PrintR($send_data);
      // Debugger::testDie();


todo_ctx_init_new(
    0,
    $send_data['todo_type'],
    $request_vars,
    $todo_ctx,
    $new_ctx,
    $send_data['origin_todo_id'],
    $acc_id,
    -1,
    $send_data['severity'],
    TODO_SUBMIT_ADD
);
//Debugger::PrintR($todo_ctx);
        //Debugger::testDie();

        todo_ctx_save(0, $todo_ctx, 0, 0,'TechnicalSupportForm[import_file_name]');
       // Debugger::PrintR($todo_ctx);
       // Debugger::testDie();


        return '';
    }

}