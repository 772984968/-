<?php
/**
* @Copyright (C) 2015
* @Author
* @Version  5.0
*/
namespace lib;

include dirname(__FILE__) . "/constants.php";
include dirname(__FILE__) . "/vendor/swift/swift_required.php";

ini_set('date.timezone', 'Asia/Shanghai');

\Yii::setAlias('@lib', LIB . DS);
\Yii::setAlias('@vendor',  LIB . DS . 'vendor' . DS);