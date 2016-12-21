<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'homeUrl'=> '/',
  //  'catchAll' => ['site/index'],
   // 'defaultRoute' => 'site/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '78356617613d60e9f33',
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
                    'pattern' => '/admin/test',
                    'route' => 'admin/basic-page/test',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => '/admin',
                    'route' => 'admin/basic-page/admin',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'logout',
                    'route' => 'site/logout',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => '/admin/basic_page',
                    'route' => 'admin/basic-page/index',
                    //'defaults' => ['page' => 1, 'tag' => ''],
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
    ];
}

return $config;
