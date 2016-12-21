<?php
namespace app\components;

use yii\web\UrlManager;
use app\models\Lang;
use Yii;
use app\components\LangObj;
use app\components\debugger\Debugger;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if( isset($params['lang_id']) ){
            //Если указан идентификатор языка, то делаем попытку найти язык в БД,
            //иначе работаем с языком по умолчанию
$lang = null;

            $l = Yii::$app->params['lang'];
            if(isset($l[$params['lang_id']])){
                $lang = new LangObj($params['lang_id']);
            }


            if( $lang === null ){
                $lang = Lang::getDefaultLang();
            }


            unset($params['lang_id']);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Lang::getCurrent();
        }
        //Debugger::Eho('</br>');
        //Debugger::Eho('</br>');
        //Debugger::Eho('</br>');
        //Debugger::Eho('</br>');
        //Debugger::Eho('</br>');
      //  Debugger::PrintR(Lang::getDefaultLang());
        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);



        //Добавляем к URL префикс - буквенный идентификатор языка
        if( $url == '/' ){
            return '/'.$lang->url;
        }else{
            //Debugger::Eho('/'.$lang->url.$url);
            return '/'.$lang->url.$url;
        }
    }
}