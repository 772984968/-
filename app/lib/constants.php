<?php
/**
* @Copyright (C) 2015
* @Author
* @Version  5.0
*/

namespace lib;

/**
 * 常量设置
 */

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('LIB') or define('LIB', dirname(__FILE__));
defined('ENCRYPTION_KEY') or define('ENCRYPTION_KEY', '12as1dsa1d35q35dsa2');

defined('APICONFIGDIR') or define('APICONFIGDIR', dirname(ROOT) . DS . 'api' . DS . 'protected' . DS . 'config' . DS);		//API 配置目录