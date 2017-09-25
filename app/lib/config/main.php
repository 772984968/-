<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Description 公共配置文件
 */

namespace lib\config;

return [
		//'bootstrap' => ['gii'],
		'modules' => [
				//'gii' => ['class' => 'yii\gii\Module'],
				//'debug' => ['class' => 'yii\debug\Module']
		],
		'language' => 'zh-CN',
		'components' => [
				'request' => [
						'cookieValidationKey' => 'asdfasdfwerqr4fsdfasdfasdfa',
				],
				'db' => require_once __DIR__ . DS . 'db.php',
				'dbyh' => [
					//主数据库配置
					'class' => 'yii\db\Connection',
					'dsn' => 'mysql:host=192.168.31.109;dbname=atapp',
					'username' => 'atkj',
					'password' => 'password',
					/*'dsn' => 'mysql:host=39.108.81.54;dbname=discovery',
                    'username' => 'atkj',
                    'password' => 'tK~yFeNXDGr#+CoSWp',*/
					'charset' => 'utf8',
					'tablePrefix' => '',
				],
				'curl' => [
						'class' => 'lib\vendor\curl\Curl',
				],
				/*'json' => [
						'class' => 'lib\vendor\json\JsonClient',
				],*/
				'upload' => [
						'class' => 'lib\upload\Uploader'
				],
				/*'encrypt' => [
						'class' => 'lib\vendor\encrypt\Encrypt',
				],*/
				/*
				'user' => [
						'identityClass' => 'app\models\User',
						'enableAutoLogin' => true,
				],
				'errorHandler' => [
						'errorAction' => 'site/error',
				],*/
				'factory' => [
					'class' => 'lib\nodes\FactoryNode',
				],
				/*'mailer' => [
						'class' => 'yii\swiftmailer\Mailer',
						'transport' => [
								'class' => 'Swift_SmtpTransport',
								'host' => 'smtp.mxhichina.com',
								'username' => 'jiahua.liu@himoke.com',
								'password' => 'jiaHUA0000',
								'port' => '25',
								'encryption' => 'tls',
						],
						'messageConfig' => [
								'charset' => 'UTF-8',
								'from' => ['jiahua.liu@himoke.com' => '艾特科技']
						],
				],
				'redis' => [
                    'class' => 'yii\redis\Connection',
                    'hostname' => '127.0.0.1',//'120.25.84.17',
                    'port' => 6379,
                    'database' => 0,
                    //'password' => '123456',
				],*/

				'cache' => [
					'class' => 'yii\caching\FileCache',
					//'class' => 'yii\redis\Cache',
					/*'class'=>'yii\caching\MemCache',
					'servers'=>[
						[
							'host'=>'127.0.0.1',
							'port'=>11211,
						],
					],*/
				],
				'urlManager' => [
						'class' => 'yii\web\UrlManager',
						'enablePrettyUrl' => true,
						'showScriptName' => false,
						'rules' => [
								'<controller:\w+>/<id:\d+>' => '<controller>/view',
								'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
								'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
						]
				],
				/*'log' => [
						'traceLevel' => YII_DEBUG ? 3 : 0,
						'targets' => [
								[
										'class' => 'yii\log\FileTarget',
										'levels' => ['error', 'warning'],
								],
						],
				],*/
				'i18n' => [
					'translations' => [
						'*' => [
							'class' => 'yii\i18n\PhpMessageSource',
							'fileMap' => [
								'common' => 'common.php',
							],
						],
					],
				],
		],
		'params' => [
		    'wy_app_key' => 'd41c9fbcccebd61dd1497c90fc69f554',
            'wy_app_secret' => 'ea815ecdd7f6',

		],
];
