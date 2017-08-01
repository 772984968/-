<?php
namespace lib\config;
return [
		//主数据库配置
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=127.0.0.1;dbname=atapp',
		'username' => 'root',
		'password' => 'jiahua',
		'charset' => 'utf8',
		'tablePrefix' => 'at_',
];
