<?php

namespace app\models;

use Yii;
use app\components\LangObj;
use yii\base\Model;
use app\components\debugger\Debugger;

/**
 * This is the model class for table "lang".
 *
 * @property integer $id
 * @property string $url
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $date_update
 * @property integer $date_create
 */
class Lang extends  Model //  \yii\db\ActiveRecord
{

    //Переменная, для хранения текущего объекта языка
    static $current = null;

/*

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */

/*
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * @inheritdoc
     */
/*

    public function rules()
    {
        return [
            [['url', 'local', 'name', 'date_update', 'date_create'], 'required'],
            [['default', 'date_update', 'date_create'], 'integer'],
            [['url', 'local', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */

/*
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'local' => Yii::t('app', 'Local'),
            'name' => Yii::t('app', 'Name'),
            'default' => Yii::t('app', 'Default'),
            'date_update' => Yii::t('app', 'Date Update'),
            'date_create' => Yii::t('app', 'Date Create'),
        ];
    }

*/
    //Получение текущего объекта языка
    static function getCurrent()
    {
        if( self::$current === null ){
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

//Установка текущего объекта языка и локаль пользователя
    static function setCurrent($url = null)
    {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->local;
    }

//Получения объекта языка по умолчанию
    static function getDefaultLang()
    {
        $lang = Yii::$app->params['lang'];
        $id_lang = 0;
        foreach($lang as $k=>$v){
            if($v['default'] == 1){
                $id_lang = $k;
            }
        }
        return new LangObj($id_lang);
       // return Lang::find()->where('`default` = :default', [':default' => 1])->one();
    }

//Получения объекта языка по буквенному идентификатору
    static function getLangByUrl($url = null)
    {
        if ($url === null) {
            return null;
        } else {
            $lang = Yii::$app->params['lang'];
            $id_lang = null;
            foreach($lang as $k=>$v){
                if($v['url'] == $url){
                    $id_lang = $k;
                }
            }
            $language = new LangObj($id_lang);


          //  $language = Lang::find()->where('url = :url', [':url' => $url])->one();
            if ( empty(get_object_vars($language)) ) {
                return null;
            }else{
                return $language;
            }
        }
    }

    static function getAllLang(){
        $lang = Yii::$app->params['lang'];
        $lang_obj_array = array();
        foreach($lang as $k=>$v){
            $lang_obj_array[$v['url']] = new LangObj($k);
        }
        return$lang_obj_array;
    }
}
