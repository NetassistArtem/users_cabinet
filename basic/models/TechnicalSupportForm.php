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
            Yii::$app->session->setFlash('TechnicalInfo', ['value' => 'Ваш запрос успешно отправлен в техническую поддержку.']);
            $this->insertTechnicalInfo();
            return true;
        } else {
            Yii::$app->session->setFlash('TechnicalInfo', ['value' => 'Не удалось отправить данные']);
            return false;
        }
    }

    public function insertTechnicalInfo()
    {
        return '';
    }

}