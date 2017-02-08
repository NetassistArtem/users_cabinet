<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');



require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$path = explode('/', $_SERVER['REQUEST_URI']);
switch ($path[1]) {
    case 'admin':
        $config = require(__DIR__ . '/../config/backend.php');
        break;

    default:
        $config = require(__DIR__ . '/../config/frontend.php');
}

require(__DIR__ . '/../components/billing_api/_.php');

require_once(__DIR__ . '/../components/billing_api/inc/common.todo_list.inc.php');
require_once(s_path("turbosms.php"));
require_once(s_path("common.asterisk.php"));

//$config = require(__DIR__ . '/../config/frontend.php');

(new yii\web\Application($config))->run();
