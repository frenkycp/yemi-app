<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'production-report',
	'name' => 'YEMI - Apps',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
		'session' => [
			'name' => 'yemi-apps',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'ru-RU',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gb56sr416y5jetd51hmn65rkur1y65',
            'parsers' => [
                'application/json' => 'yii/web/JsonParser'
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '-',
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
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'asset-tbl-rest',
                    'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'incoming-material-rest',
                    'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'production-plan-rest',
                    'pluralize' => false,
                ]
            ),
        ],
        /*
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],
        */
		'assetManager' => [
			'bundles' => [
				'dmstr\web\AdminLteAsset' => [
					'skin' => 'skin-black',
				],
			],
		],
        'db' => require(__DIR__ . '/db.php'),
        'db_sql_server' => require(__DIR__ . '/db_sql_server.php'),
        'db_mis7' => require(__DIR__ . '/db_mis7.php'),
        //'db_mis_bak' => require(__DIR__ . '/db_mis_bak.php'),
        'db_wsus' => require(__DIR__ . '/db_wsus.php'),
        'db_wh_app' => require(__DIR__ . '/db_wh_app.php'),
        'db_mrbs' => require(__DIR__ . '/db_mrbs.php'),
        'db_supplement' => require(__DIR__ . '/db_supplement.php'),
        'db_redy' => require(__DIR__ . '/db_redy.php'),
        'db_spr' => require(__DIR__ . '/db_spr.php'),
        'db_iot' => require(__DIR__ . '/db_iot.php'),
        'db_rep' => require(__DIR__ . '/db_rep.php'),
        'db_sun_fish' => require(__DIR__ . '/db_sun_fish.php'),
        'db_server_status' => require(__DIR__ . '/db_server_status.php'),
    ],
    'params' => $params,
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
    ],
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
