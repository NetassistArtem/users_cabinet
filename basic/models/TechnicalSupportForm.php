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
                'import_file_name'
            ], 'trim'],
            ['import_file_name', 'file', 'extensions' => ['png', 'jpg', 'gif','tiff','pdf','obt','doc','docs','txt'], 'maxFiles' =>4, 'maxSize' => 1024*1024*3],
[['todo_desc', 'problem_appeared', 'avir_present'],'filter','filter' => function($value){
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
            Yii::$app->session->setFlash('TechnicalInfo', ['value' => Yii::t('flash-message', 'request_sent_support')]);
            $this->insertTechnicalInfo();
            return true;
        } else {
            Yii::$app->session->setFlash('TechnicalInfo', ['value' => Yii::t('flash-message', 'unable_send_data')]);
            return false;
        }
    }

    public function insertTechnicalInfo()
    {


        global $request_vars;
        global $todo_ctx;



        User::UserData();
        $send_data = Yii::$app->request->post('TechnicalSupportForm');
        $acc_id = isset($send_data['ref_acc_id']) ? $send_data['ref_acc_id'] : -1;

        $new_ctx = array(
            "subj" => transcode_utf8_to_internal($send_data['subj']),// iconv_safe('utf-8','koi8-u',  $send_data['subj']),
          //  "ref_acc_id" => $acc_id,
            "todo_desc" => transcode_utf8_to_internal($send_data['todo_desc']),// iconv_safe('utf-8','koi8-u',  $send_data['todo_desc']),
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
  //      Debugger::testDie();
        todo_ctx_save(0, $todo_ctx, 0, 0,'TechnicalSupportForm[import_file_name]');
        return '';
    }

}