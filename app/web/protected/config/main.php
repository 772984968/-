<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Version  Beta 1.0
 */

namespace app\config;

use yii\helpers\ArrayHelper;

//载入公共配置
require_once ROOT.'/../lib/autoload.php';

//载入配置文件
$globals_config = require_once LIB.'/config/main.php';

//当前配置项
$config = [
		'id' => 'web',
		'basePath' => dirname(__DIR__),
        'defaultRoute' => 'index',
        'params' => require_once dirname(__FILE__).'/params.php',
        'components' => [
            'errorHandler' => [
                'errorAction' => 'u/error',
            ],
            //禁止使用本框架的jquery
            'assetManager' =>[
            	'bundles' => [
            		'yii\web\JqueryAsset' => [
            			'sourcePath' => null,
            			'js' => []
            		],
            	],
            ],
        ],
];

return ArrayHelper::merge($globals_config, $config);
