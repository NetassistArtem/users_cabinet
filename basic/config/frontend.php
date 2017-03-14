<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'homeUrl'=> '/cabinet',
  //  'catchAll' => ['site/index'],
    'defaultRoute' => 'static-page/cabinet',
    'language'=>'ru-RU',
    'components' => [

        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-EN',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '78356617613d60e9f33',
            'class' => 'app\components\LangRequest',
            'baseUrl' => '',

        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class'=>'app\components\LangUrlManager',
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'collapseSlashes' => true,
            ],
            'rules' => [
                [
                    'pattern' => 'home',
                    'route' => 'site/index',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'about',
                    'route' => 'site/about',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'contact',
                    'route' => 'site/contact',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'login',
                    'route' => 'site/login',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'logout',
                    'route' => 'site/logout',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'phone',
                    'route' => 'site/contact',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'cabinet',
                    'route' => 'static-page/cabinet',
                    //'defaults' => ['page' => 1, 'tag' => '']
                ],
                [
                    'pattern' => 'upravlenie-kabinetom',
                    'route' => 'static-page/cabinet-management',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'oplata-uslug',
                    'route' => 'static-page/payment',
                    //'defaults' => ['page' => 1, 'tag' => '']
                ],
                [
                    'pattern' => 'oplata-uslug/terminals',
                    'route' => 'static-page/terminals',
                    //'defaults' => ['page' => 1, 'tag' => '']
                ],
                [
                    'pattern' => 'oplata-uslug/bank',
                    'route' => 'static-page/bank',
                    //'defaults' => ['page' => 1, 'tag' => '']
                ],
                [
                    'pattern' => 'istoriya-platezhey',
                    'route' => 'static-page/payment-history',
                    //'defaults' => ['page' => 1, 'tag' => ''
                ],
                [
                    'pattern' => 'tehnicheskaya-podderzhka',
                    'route' => 'static-page/support',

                ],
                [
                    'pattern' => 'istoriya-obrascheniy',
                    'route' => 'static-page/support-history',

                ],
                [
                    'pattern' => 'istoriya-obrascheniy/<todo-id:([0-9]){1,6}>',
                    'route' => 'static-page/support-history-todo',

                ],
                [
                    'pattern' => 'ostavit-otzyiv',
                    'route' => 'static-page/feedback',

                ],
                [
                    'pattern' => 'televidenie',
                    'route' => 'static-page/tv',

                ],
                [
                    'pattern' => 'call-request',
                    'route' => 'static-page/call-request',

                ],
                [
                    'pattern' => 'istoriya-obrascheniy/call-request',
                    'route' => 'static-page/call-request',

                ],
                [
                    'pattern' => 'submit-call-request',
                    'route' => 'static-page/submit-call-request',

                ],

                [
                    'pattern' => 'page-test1?id=1',
                    'route' => 'basic-page/view',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'color',
                    'route' => 'static-page/color',

                ],
                [
                    'pattern' => 'phone-first-change-confirm',
                    'route' => 'static-page/phone-first-change-confirm',

                ],
                [
                    'pattern' => 'phone-change',
                    'route' => 'static-page/phone-change',

                ],
                [
                    'pattern' => 'email-change',
                    'route' => 'static-page/email-change',

                ],
                [
                    'pattern' => 'email-change-confirm',
                    'route' => 'static-page/email-change-confirm',

                ],
                [
                    'pattern' => 'arhiv-novostei',
                    'route' => 'static-page/arhiv-news',

                ],


            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        //'allowedIPs' => ['62.205.155.77']
    ];
}

return $config;
