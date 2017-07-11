<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class KuziaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/kuzia.css',
        'css/color.css',
        '/css/font-awesome-4.7.0/css/font-awesome.min.css'
    ];
    public $js = [
        'css/js/site.js',
        'scripts/Inputmask-4.x/js/inputmask.js',
        'scripts/Inputmask-4.x/js/inputmask.extensions.js',
        'scripts/Inputmask-4.x/js/inputmask.phone.extensions.js',
        'scripts/Inputmask-4.x/js/jquery.inputmask.js',
        'scripts/phoneMaskCallReq.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
