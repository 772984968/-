<?php

namespace app\config;
/**
 * api接口URL构造
 * name：接口名称
 * make：接口权限 1：公开，2：登录，
 * status：接口状态，1：开放，-1：关闭
 * logs: 0:不记录，1：记录日志
 * mark: false 不需要版本校验, 不设置或者true则校验版本
 * vist: 每分钟最大访问量
 */
/**系统**/
$apiUrl['labeladd']			= ['name'=>'添加标签',		'controller' =>'label',	'method' => 'add',	    'sign' => 0, 'make'=>1, 'status'=>1];















return $apiUrl;