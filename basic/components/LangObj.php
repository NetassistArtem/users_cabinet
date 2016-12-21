<?php


namespace app\components;

use Yii;
use app\components\debugger\Debugger;


class LangObj
{
    public $id;
    public $url;
    public $local;
    public $name;
    public $default;
    public $symbol;

    public function __construct($lang_id)
    {
        $lang = Yii::$app->params['lang'][$lang_id];

        if ($lang !== null) {
            $this->id = $lang['id'];
            $this->url = $lang['url'];
            $this->local = $lang['local'];
            $this->name = $lang['name'];
            $this->default = $lang['default'];
            $this->symbol = $lang['symbol'];
        } else {
            $this->__destruct();
        }


    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->url);
        unset($this->local);
        unset($this->name);
        unset($this->default);
        unset($this->symbol);

        // TODO: Implement __destruct() method.
    }


}