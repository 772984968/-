<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Description JSON组件
 */

namespace lib\vendor\json;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\HttpException;

class JsonClient extends Component
{

	/**
	 * 初始化
	 * @return boolean
	 */
	public function init()
	{
		return true;
	}

	/**
	 * 生成JSON
	 * @param $value
	 */
	public function encode($value)
	{
		echo $this->_encode($value);
		exit;
	}

	/**
	 * 返回JSON
	 * @param $value
	 */
	public function return_encode($value)
	{
		return $this->_encode($value);
	}

	/**
	 * 解析JSON
	 * @param string $json
	 * @return boolean|null
	 */
	public function decode($json)
	{
		switch(strtolower($json))
		{
			case 'true':
				return true;
			case 'false':
				return false;
			case 'null':
				return null;
			default:
				return (array) Json::encode($json);
		}
	}

	/**
	 * JSON
	 * @param type $var
	 * @return string
	 */
	public function _encode($var)
	{
		switch(gettype($var))
		{
			case 'boolean':
				return $var ? 'true' : 'false';
			case 'NULL':
				return 'null';
			case 'integer':
				return (int) $var;
			case 'float':
				return (float) $var;
			case 'string':
				return '"'.$var.'"';
			case 'array':
				return urldecode(Json::encode($this->_urlencode($var)));
//				return Json::encode($this->_urlencode($var));
			case 'object':
				$vars = get_object_vars($var);
				$properties = array_map(array($this, 'name_value'), array_keys($vars), array_values($vars));
				return urldecode(Json::encode($this->_urlencode($properties)));
			default:
				return 'null';
		}
	}

	/**
	 * 将字符串以URL编码返回值
	 * @param array $array
	 * @return array
	 */
	public function _urlencode($array)
	{
		if(is_array($array)&&!empty($array))
		{
			foreach($array as $k => $v)
			{
				if(is_array($v))
				{
					$array[$k] = $this->_urlencode($v);
				}
				else
				{
					$array[$k] = $this->preg_utf8($v);
				}
			}
		}
		else
		{
			$array = $this->preg_utf8($array);
		}
		return $array;
	}

	/**
	 * 判断是否为字符串
	 * @param string $string
	 * @return type
	 */
	public function preg_utf8($string)
	{
		if(is_string($string))
		{
			return urlencode($string);
		}
		return $string;
	}

	/**
	 * 转换名称
	 * @param type $name
	 * @param type $value
	 * @return type
	 */
	public function name_value($name, $value)
	{
		$encoded_value = $this->_encode($value);
		return $this->_encode(strval($name)).':'.$encoded_value;
	}
}