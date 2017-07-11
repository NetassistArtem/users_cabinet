<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use yii\web\UploadedFile;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

class FeedbackForm extends Model
{

    public $todo_desc;
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






    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            ['todo_desc', 'required'],

            ['todo_desc','filter','filter' => function($value){
                strip_tags($value);
                return $value;
            }],

            ['files', 'file', 'extensions' => ['png', 'jpg', 'gif','tiff','pdf','obt','doc','docs','txt'], 'maxFiles' =>4, 'maxSize' => 1024*1024*3],


        ];
    }

    public function setFeedback()
    {
        if ($this->validate()) {
            $this->sendFeedback();
          //  Debugger::PrintR($_FILES);
          //  Debugger::testDie();
            Yii::$app->session->setFlash('feedback', ['value' => Yii::t('flash-message', 'message_sent')]);

            return true;
        } else {
            Yii::$app->session->setFlash('feedback', ['value' => Yii::t('flash-message', 'unable_send_message')]);
            return false;
        }
    }

    public function sendFeedback()
    {
        //Сохранение файлов методами Yii, раскоментить в случае когда не работает загрузка из аппи биллинга
     /*   $this->files = UploadedFile::getInstances($this, 'files');


        if($this->files){

            foreach( $this->files as $file){
                $file->saveAs(Yii::$app->getBasePath().'/web/upload/' . $file->baseName . '.' . $file->extension);
            }

           Debugger::Eho('</br>');
            Debugger::Eho('</br>');
            Debugger::Eho('</br>');
            Debugger::PrintR($_FILES);
            Debugger::testDie();
        } */

        global $opt_vars;
        global $todo_ctx;
        User::UserData();
        $send_data = Yii::$app->request->post('FeedbackForm');
//$tes= Html::encode($send_data['todo_desc']);
     //   Debugger::EhoBr( $tes);

      //  Debugger::testDie();
        $acc_id = isset($send_data['ref_acc_id']) ? $send_data['ref_acc_id'] : -1;

        $new_ctx = array(
            "subj" => transcode_utf8_to_internal($send_data['subj']), // iconv_safe('utf-8','koi8-u',  $send_data['subj']),
            "ref_acc_id" => $acc_id,
            "todo_desc" => transcode_utf8_to_internal($send_data['todo_desc']), //iconv_safe('utf-8','koi8-u',  $send_data['todo_desc']),
            "todo_type" => $send_data['todo_type'],
            "exec_list" => $send_data['exec_list'],

        );

        todo_ctx_init_new(
            0,
            $send_data['todo_type'],
            $opt_vars,
            $todo_ctx,
            $new_ctx,
            $send_data['origin_todo_id'],
            $acc_id,
            -1,
            $send_data['severity']
        );
        $edit = $send_data['edit_req'] ? $send_data['edit_req'] : 0;

      todo_ctx_save(0, $todo_ctx, $edit,0,'FeedbackForm[files]');




        return '';
    }

}