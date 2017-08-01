<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Version  5.0
 */

namespace app\components;

/**
 * API 基类
 */
use Yii;
use yii\helpers\Json;
use yii\web\HttpException;
//use app\models\UsersModels;

class ApiPost
{

    /**
     * request请求校验
     * @return [type] [description]
     */
    public static function requestCheck()
    {
        //请求类型判断
        if (!Yii::$app->request->getIsPost())
        {
            self::error('The request method must be POST');
        }
		
        //获取请求的api url并判断
        if (Yii::$app->request->get('url', false) === false)
        {
            self::error("The request url can't be empty");
        }
        if (!isset(Yii::$app->params['apiurl'][Yii::$app->request->get('url')]))
        {
            self::error('The request url error');
        }
        if (count(Yii::$app->params['apiurl'][Yii::$app->request->get('url')]) < 5)
        {
            self::error('Api config error');
        }
        //判断来源
        if (Yii::$app->request->post('appid', false) === false)
        {
            self::error("appid can't be empty");
        }
        //判断来源
        if (Yii::$app->request->post('version', false) === false)
        {
        	self::error("version can't be empty");
        }
        //判断来源
        if (Yii::$app->request->post('from', false) === false)
        {
        	self::error("from can't be empty");
        }
        //判断来源
        if (Yii::$app->request->post('ts', false) === false)
        {
        	self::error("ts can't be empty");
        }
        //判断来源
        if (Yii::$app->request->post('mark', false) === false)
        {
        	self::error("mark can't be empty");
        }
        return true;
    }

    /**
     * 开始请求验证
     * @param  [type] $apiData [description]
     * @return [type]          [description]
     */
    public static function requestStart($apiData)
    {
        $retData['from']         = Yii::$app->request->post('from');
        //$retData['request_stime']= Yii::$app->request->post('request_stime', time());
        $retData['uid']          = 0;
        $retData['status']       = 1;

		$param = Yii::$app->request->post('param')?json_decode(Yii::$app->request->post('param'),true):'';
        $token = (!empty($param) && isset($param['token'])) ? $param['token'] : null;
        if (!isset($apiData['status']) || $apiData['status'] != 1 || !isset($apiData['make']))
        {
            self::error(Yii::t('app', 'apiclose'));
        }
        //校验sign
//        if ($apiData['sign'] == 1)
//        	{
//        		$appid = Yii::$app->request->post('appid');
//        		$version = Yii::$app->request->post('version');
//        		$from = Yii::$app->request->post('from');
//        		$ts = Yii::$app->request->post('ts');
//        		$mark = Yii::$app->request->post('mark');
//        		$sign = Yii::$app->request->post('sign', false);
//        		$_sign = md5("appid=".$appid."&version=".$version."&from=".$from."&ts=".$ts."&mark=".$mark);
//        		if ($sign === false)
//        		{
//        			self::error("sign can't be empty");
//        		}
//        		if ($_sign !=$sign)
//        		{
//        			self::error("sign error");
//        		}
//
//        	}
        //登录校验
        if ($apiData['make'] == 2)
        {
            if (empty($token))
            {
                self::error(Yii::t('app', 'nonetoken'));
            }
            $token_return = self::checkUserToken($token);
            if ($token_return['status'] != 1)
            {
				Yii::$app->json->encode($token_return);
            }
            
            $retData['uid'] = $token_return['data']['uid'];
        }
        elseif (!empty($token))
        {
            $token_return = self::checkUserToken($token);
            
            if ($token_return['status'] == 1)
            {
                $retData['uid'] = $token_return['data']['uid'];
            }
        }
        //记录日志
        if (isset($apiData['logs']) && $apiData['logs'] == 1)
        {
            $retData['logs'] = [];
        }
        return $retData;
    }
	
	/**
	 * 校验用户Token
	 * @param  [type] $token [description]
	 * @return [type]        [description]
	 */
	public static function checkUserToken($token = null)
	{
		$uid = \app\components\ApiCommon::undoToken($token);
		if($uid <= 0)
		{
			return ['status' => -2, 'message' => \Yii::t('app', 'token_error')];
		}

		$userData = \lib\models\User::findOne(['id' => $uid, 'status' => 2]);
		if(empty($userData))
		{
			return ['status' => -2, 'message' => \Yii::t('app', 'nologon')];
		}
		if(empty($userData['token'])||$userData['token']!=$token)
		{
			return ['status' => -2, 'message' => \Yii::t('app', 'nologon')];
		}
		return ['status' => 1, 'data' => ['uid' => $uid]];
	}

    /**
     * 请求数据
     * @param  [type] $postData [description]
     * @return [type]         [description]
     */
    public static function requestPostData($postData = [])
    {
        if (isset($postData['from']))
        {
            unset($postData['from']);
        }
        if (isset($postData['mark']))
        {
            unset($postData['mark']);
        }
        if (isset($postData['version']))
        {
            unset($postData['version']);
        }
        if (isset($postData['sign']))
        {
            unset($postData['sign']);
        }
        if (isset($postData['token']))
        {
            unset($postData['token']);
        }
        return $postData;
    }

    /**
     * 结束请求
     * @param  [type] $return [description]
     * @return [type]         [description]
     */
    public static function requestEnd($return)
    {
        if (isset($return['request_stime']))
        {
            $return['time'] = time() - $return['request_stime'] . 's';
            unset($return['request_stime']);
        }
        if (isset($return['token']))
        {
            unset($return['token']);
        }
        if (isset($return['from']))
        {
            unset($return['from']);
        }
		if (isset($return['uid']))
        {
            unset($return['uid']);
        }
		if (isset($return['sid']))
        {
            unset($return['sid']);
        }
        if (isset($return['data']) && empty($return['data']))
        {
            $return['data'] = array();
        }

        $encode = !empty($return) ? $return : self::error('No data is returned');
        Yii::$app->json->encode($encode);
    }

	/**
	 * 错误信息输出
	 * @param type $message
	 */
	public static function error($message = '')
	{
		Yii::$app->json->encode(['status' => -3, 'message' => Yii::t('app', "apierror") . "：{$message}"]);
	}
}