<?php
// 框架路径，配置信息路径，项目路径
$yii = dirname(__FILE__).'/../../frame/Yii.php';
$main = dirname(__FILE__).'/protected/config/main.php';
$app_root = dirname(__FILE__).DIRECTORY_SEPARATOR;

//项目目录绝对路径
defined('ROOT') or define('ROOT', $app_root);
defined('APPROOT') or define('APPROOT', $app_root.'protected');
// 是否开启DEBUG
defined('YII_DEBUG') or define('YII_DEBUG', true);
// Yii 将然后追加文件名和调用栈的行号到每条跟踪信息中。 数字 YII_TRACE_LEVEL 决定每个调用栈的几层应当被记录
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
//开始
defined('HUANG_JING') or define('HUANG_JING',1);   //0为线下,1为线上
require_once($yii);
require_once(dirname(__FILE__).'/../lib/config/bootstrap.php');
$config = require_once($main);

/*function getmicrotime()
{
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

// 记录开始时间
$time_start = getmicrotime();*/

// 这里放要执行的PHP代码，如:
// echo create_password(6);

(new yii\web\Application($config))->run();
