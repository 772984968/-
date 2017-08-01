<?php
namespace lib\components;
use Yii;

class Sms
{
	/**
     * @desc 魔术方法
     * @param type $name 名称
     * @param type $value 数据
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * 实例化本类
     * @return type
     */
    public static function app($className=__CLASS__)
    {
        return new $className();
    }

    /**
	 * 错误信息
	 * @param type $status
	 * @return type
	 */
    public function error($status = -1)
    {
        $error = array(
						'-1' => '签权失败',
						'-2' => '未检索到被叫号码',
						'-3' => '被叫号码过多',
						'-4' => '内容未签名',
						'-5' => '内容过长',
						'-6' => '余额不足',
						'-7' => '暂停发送',
						'-8' => '保留',
						'-9' => '定时发送时间格式错误',
						'-10' => '下发内容为空',
						'-11' => '账户无效',
						'-12' => 'Ip地址非法',
						'-13' => '操作频率快',
						'-14' => '操作失败',
						'-15' => '拓展码无效',
						'-16' => '取消定时,seqid错误',
						'-17' => '未开通报告',
						'-18' => '暂留',
						'-19' => '未开通上行',
						'-20' => '暂留',
						'-21' => '包含屏蔽词');
        return isset($error[$status]) ? $error[$status] : '错误不详';
    }

    /**
	 * 发送验证码
	 * @param type $mobile
	 * @param string $msg
	 * @return type
	 */
    public function send($mobile = '', $msg = '')
    {
        if (empty($mobile) || empty($msg))
        {
            return array('status' => -1, 'msg' => '请求参数错误');
        }
		$smsText = $msg;
		$setting = \Yii::$app->params['setting'];
//		$smsUrl = "http://sms.10690221.com:9011/hy/?uid=80772&auth=ddca9916f2e09348e6160ba484da5f1e&mobile={$mobile}&msg={$smsText}&expid=0&encode=utf-8";
		$smsUrl = $setting['sms_url'] . "?uid={$setting['sms_user']}&auth={$setting['sms_pawd']}&mobile={$mobile}&msg={$smsText}&expid=0&encode=utf-8";
		if(function_exists('file_get_contents'))
		{
			$return = file_get_contents($smsUrl);
		}
		else
		{
			$return = Yii::$app->curl->get($smsUrl);
		}
		$returnData =  array('status' => intval($return) == 0 ? 0 : -3);
		if ($return < 0)
		{
			$returnData['msg'] = $this->error($return);
		}
		return $returnData;
    }
}