<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Version  5.0
 */

namespace app\components;

use yii;
use yii\helpers\Json;

class ApiCommon
{

	/**
	 * 生成加密TOKEN
	 * @param type $key 标识码
	 * @return type
	 */
	public static function createToken($key)
	{
		return Yii::$app->encrypt->encode($key).'@@'.uniqid();
	}

	/**
	 * 解开用户Token
	 * @param type $token
	 * @return type
	 */
	public static function undoToken($token)
	{
		//$token ='xyUa4hkf5IhmMzHg8DSXKMBG2SeAmciyh2kiZCoKi8uaPYLr3WjvDtnhAsimSU/iXd3gftm0JwM9U2iXLHpAJA==@@56443ac811768';
		$token_array = explode("@@", $token);
		
		if (count($token_array) != 2)
		{
			return 0;
		}
		$id = Yii::$app->encrypt->decode($token_array[0]);
		return intval($id);
	}

	/**
	 * 生成唯一字符串
	 * @return string
	 */
	public static function uniqueGuid()
	{
		$charid = strtoupper(md5(uniqid(mt_rand(), true)));
		$uuid = substr($charid, 0, 8).substr($charid, 8, 4).substr($charid, 12, 4).substr($charid, 16, 4).substr($charid, 20, 12);
		return $uuid;
	}
	/**
     * 产生随机字符串
     * @param int $len 产生字符串的位数
     * @return string
     */
    public static function randStr($len=10, $type = 1) {
        switch ($type) {
            case 2:
                $chars='abdefghijkmnpqrstvwxy123456789';
                break;
            case 3:
                $chars='123456789';
                break;
            case 1:
            default:
                $chars='ABDEFGHJKLMNPQRSTVWXYabdefghijkmnpqrstvwxy123456789';
                break;
        }
        mt_srand((double)microtime() * 1000000 * getmypid());
        $salt = '';
        for ($i = 1, $j = strlen($chars); $i <= $len; $i++) {
            $salt .= $chars{mt_rand() % $j};
        }
        return $salt;
    }

	/**
	 * 姓名昵称合法性检查，只能输入中文英文
	 * @access public
	 * @param  $val 被检查内容
	 * @return bool true false
	 */
	public static function isName($val)
	{
		if(preg_match("/^[\x80-\xffa-zA-Z0-9]{3,60}$/", $val))
		{
			return true;
		}
		return false;
	}

	/**
	 * 检查输入的是否为数字
	 * @access public
	 * @param  $val 
	 * @return bool true false
	 */
	public static function isNumber($val)
	{
		if(preg_match("/^[0-9]+$/", $val))
		{
			return true;
		}
		return false;
	}

	/**
	 * 检查输入的是否为电话
	 * @access public
	 * @param  $val 
	 * @return bool true false
	 */
	public static function isPhone($val)
	{
		if(preg_match("/^(13|15|18|14)[0-9]{9}$/", $val))
		{
			return true;
		}
		return false;
	}

	/**
	 * 检查输入的是否为手机号
	 * @access public
	 * @param  $val 
	 * @return bool true false
	 */
	public static function isMobile($val)
	{
		//该表达式可以验证那些不小心把连接符“-”写出“－”的或者下划线“_”的等等
		if(preg_match("/^13[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/", $val))
		{
			return true;
		}
		return false;
	}

	/**
	 * 检查输入的是否为邮编
	 * @access public
	 * @param  $val 
	 * @return bool true false
	 */
	public static function isPostcode($val)
	{
		if(preg_match("/^[0-9]{4,6}$/", $val))
		{
			return true;
		}
		return false;
	}

	/**
	 * 邮箱地址合法性检查
	 * @access public
	 * @param  $val 
	 * @param  $domain
	 * @return bool true false
	 */
	public static function isEmail($val, $domain = "")
	{
		if(!$domain)
		{
			if(preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $val))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			if(preg_match("/^[a-z0-9-_.]+@".$domain."$/i", $val))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	/**
	 * 验证身份证号
	 * @param $vStr
	 * @return bool
	 */
	public static function isCreditNo($vStr)
	{
		$vCity = array(
				'11', '12', '13', '14', '15', '21', '22',
				'23', '31', '32', '33', '34', '35', '36',
				'37', '41', '42', '43', '44', '45', '46',
				'50', '51', '52', '53', '54', '61', '62',
				'63', '64', '65', '71', '81', '82', '91'
		);

		if(!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr))
		{
			return false;
		}

		if(!in_array(substr($vStr, 0, 2), $vCity))
		{
			return false;
		}

		$vStr = preg_replace('/[xX]$/i', 'a', $vStr);
		$vLength = strlen($vStr);

		if($vLength==18)
		{
			$vBirthday = substr($vStr, 6, 4).'-'.substr($vStr, 10, 2).'-'.substr($vStr, 12, 2);
		}
		else
		{
			$vBirthday = '19'.substr($vStr, 6, 2).'-'.substr($vStr, 8, 2).'-'.substr($vStr, 10, 2);
		}

		if(date('Y-m-d', strtotime($vBirthday))!=$vBirthday)
		{
			return false;
		}
		if($vLength==18)
		{
			$vSum = 0;

			for($i = 17; $i>=0; $i--)
			{
				$vSubStr = substr($vStr, 17-$i, 1);
				$vSum += (pow(2, $i)%11)*(($vSubStr=='a') ? 10 : intval($vSubStr, 11));
			}

			if($vSum%11!=1)
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * 检查字符串长度是否符合要求(仅限于数字)
	 * @access public
	 * @param  int $val 
	 * @param  int $min 最小长度
	 * @param  int $max 最大长度
	 * @return bool true false
	 */
	public static function isNumLength($val, $min, $max)
	{
		$theelement = trim($val);
		if(preg_match("/^[0-9]{".$min.",".$max."}$/", $val))
		{
			return true;
		}
		return false;
	}

	/**
	 * 检查字符串长度是否符合要求(仅限于阿拉伯字母)
	 * @access public
	 * @param  string $val 
	 * @param  int $min 最小长度
	 * @param  int $max 最大长度
	 * @return bool true false
	 */
	public static function isEngLength($val, $min, $max)
	{
		$theelement = trim($val);
		if(preg_match("/^[a-zA-Z]{".$min.",".$max."}$/", $val))
		{
			return true;
		}
		return false;
	}

	/**
	 * 检查输入是否为英文
	 * @access public
	 * @param  string $theelement 
	 * @return bool true false
	 */
	public static function isEnglish($theelement)
	{
		if(preg_match("[\x80-\xff].", $theelement))
		{
			return false;
		}
		return true;
	}

	/**
	 * 检查是否输入为汉字
	 * @access public
	 * @param  string $sInBuf 
	 * @return bool true false
	 */
	public static function isChinese($val)
	{
		if(!preg_match("/[^\x80-\xff]/", $val))
		{
			return true;
		}
		return false;
	}

	/**
	 * 检查日期是否符合0000-00-00
	 * @access public
	 * @param  date $sDate Y-m-d
	 * @return bool true false
	 */
	public static function isDate($sDate)
	{
		if(preg_match("/^[0-9]{4}\-[][0-9]{2}\-[0-9]{2}$/", $sDate))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @desc 返回错误信息
	 * @param type $array
	 * @return type
	 */
	public static function modelMessage($array)
	{
		if (count($array) <= 0)
		{
			return;
		}
		$msg = '操作错误：';
		foreach ($array as $val)
		{
			$msg .= isset($val[0]) ? $val[0] : $val;
		}
		return $msg;
	}
	
}