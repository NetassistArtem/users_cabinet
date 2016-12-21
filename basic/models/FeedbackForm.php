<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use yii\web\UploadedFile;

class FeedbackForm extends Model
{

    public $message;
    public $files;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            ['message', 'required'],

            ['message','filter','filter' => function($value){
                strip_tags($value);
                return $value;
            }],

            ['files', 'file', 'extensions' => ['png', 'jpg', 'gif','tiff','pdf','obt','doc','docs','txt'], 'maxFiles' =>4, 'maxSize' => 1024*1024*3],


        ];
    }

    public function setFeedback()
    {
        if ($this->validate()) {

            Yii::$app->session->setFlash('feedback', ['value' => 'Сообщение отправленно']);
            $this->sendFeedback();
            return true;
        } else {
            Yii::$app->session->setFlash('feedback', ['value' => 'Не удалось отправить сообщение']);
            return false;
        }
    }

    public function sendFeedback()
    {
        $this->files = UploadedFile::getInstances($this, 'files');

        if($this->files){

            foreach( $this->files as $file){
                $file->saveAs(Yii::$app->getBasePath().'/web/upload/' . $file->baseName . '.' . $file->extension);
            }


        }
        return '';
    }

}