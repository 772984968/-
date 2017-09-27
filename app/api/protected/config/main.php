<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Version  Beta 1.0
 */

namespace app\config;

use yii\helpers\ArrayHelper;

//载入公共配置
require_once ROOT . '/../lib/autoload.php';

//载入配置文件
$globals_config = require_once LIB . '/config/main.php';


//当前配置项
$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'index',
    'controllerNamespace' => 'api\controllers',
    'params' => [
        'sid' => 0,
        'apiurl' => require_once __DIR__ . DS . 'apiurl.php',
        'webpath' => 'http://api.atapp.cc',
        'longImageWidth' => 1024,
        'longImageHeight'=> 614,
    ],
    'components' => [
        'user' => [
            'identityClass' => 'api\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
    ],
];
    
return ArrayHelper::merge($config, $globals_config);
