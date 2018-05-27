<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/x-www-form-urlencoded' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'charset' => 'UTF-8',
        ],
        'user' => [
            'identityClass' => 'common\models\UserIdentity',
            'enableSession' => false,
            'enableAutoLogin' => false,
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['api'],
                    'logFile' => '@runtime/logs/api.log',
                    'logVars' => [],   // $_GET, $_POST, $_FILES, $_COOKIE, $_SESSION, $_SERVER
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,           // pluralise
            'showScriptName' => false,
            'rules' => [
                'user/verification/<token:[0-9a-zA-Z\-\_]+>' => 'user/verification',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'price'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'product'],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'order',
                    'extraPatterns' => [
                        'POST create' => 'create',
                        'POST add' => 'add-items',
                        'GET orders' => 'orders',

                        'OPTIONS create' => 'options',
                        'OPTIONS add' => 'options',
                        'OPTIONS orders' => 'options',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => 'by',
                    'extraPatterns' => [
                        'GET category/<id:\d+>' => 'category',

                        'OPTIONS category/<id:\d+>' => 'options',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => 'auth',
                    'extraPatterns' => [
                        'POST signup' => 'signup',
                        'POST login' => 'login',
                        'GET signup' => 'signup',

                        'OPTIONS signup' => 'options',
                        'OPTIONS login' => 'options',
                    ],
                ],

            ],
        ],

    ],
    'params' => $params,
];
