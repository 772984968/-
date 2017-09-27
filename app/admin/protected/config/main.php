<?php
/**
* @Copyright (C) 2015
* @Author
* @Version  Beta 1.0
*/
namespace app\config;
use yii\helpers\ArrayHelper;
//载入公共配置
require_once ROOT.'/../lib/constants.php';
require_once ROOT.'/../lib/autoload.php';

//载入配置文件
$globals_config = require_once LIB.'/config/main.php';

//当前配置项
$config = [
        'id' => 'admin',
        'basePath' => dirname(__DIR__),
        'defaultRoute' => 'login/index',
        'params' => require_once dirname(__FILE__).'/params.php',
        'components' => [
            'assetManager' => [
                'bundles' => [
                    'yii\web\JqueryAsset' => false,
                    'yii\web\YiiAsset'    => false,
                ],
            ],
            'upload' => function(){
            	return new \app\components\Upload;
            },
        ]
];

return ArrayHelper::merge($globals_config, $config);