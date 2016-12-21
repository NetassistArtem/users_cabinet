<?php
namespace app\widgets;

use app\models\Lang;

class WLang extends \yii\bootstrap\Widget
{
    public function init(){}

    public function run() {

        $current_lang = Lang::getCurrent();
        $lang_all = Lang::getAllLang();
        $lang_without_current = $lang_all;
        unset($lang_without_current[$current_lang->url]);


        return $this->render('lang/view', [
            'current_lang' => $current_lang,
            'lang_all' => $lang_all,
            'lang_without_current' => $lang_without_current,

        ]);
    }
}