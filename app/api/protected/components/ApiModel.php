<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Version  5.0
 */

namespace app\components;

use Yii;
use app\components\ApiCommon;

/**
 * ApiModel
 */
class ApiModel
{

    /**
     * API 配置信息
     * @var array
     */
    public $apiData = array();

    /**
     * 请求初始化数据
     * @var array
     */
    public $retData = array();

    /**
     * 请求参数
     * @var array
     */
    public $requestData = array();

    /**
     * 请求对象
     * @var null
     */
    public $obj = null;

    /**
     * 析构函数
     * @param [type] $object [description]
     */
    public function __construct($object = null)
    {
        if ($this->obj === null)
        {
            $this->obj = $object;
        }
    }

    /**
     * 验证数据
     * @access protected
     * @param int $data 数据
     * @param bool $type 判断类型 string|int|bool
     * @return mixed
     */
    protected function request_verify($data, $type = 'string')
    {
        if(!is_array($data))
        {
            $data = array($data);
        }
        switch($type)
        {
            case 'string':
                foreach($data as $val)
                {
                    if (!isset($this->requestData[$val]) || !is_string($this->requestData[$val]) || empty($this->requestData[$val]))
                    {
                        return false;
                    }
                }
                break;
            case 'int':
                foreach($data as $val)
                {
                    if (!isset($this->requestData[$val]) || !is_numeric($this->requestData[$val]))
                    {
                        return false;
                    }
                }
                break;
            case 'bool':
                foreach($data as $val)
                {
                    if (!isset($this->requestData[$val]) || !is_bool($this->requestData[$val]))
                    {
                        return false;
                    }
                }
                break;
            case 'date':
                foreach($data as $val)
                {
                    if (!isset($this->requestData[$val]) || !ApiCommon::isDate($this->requestData[$val]))
                    {
                        return false;
                    }
                }
                break;
        }   
        return true;
    }

    /**
     * 获取数据
     * @access protected
     * @param $key 获取的变量名称
     * @param $default 默认返回
     * @return mixed
     */
    protected function get($key, $default = "")
    {
        if(is_array($key))
        {
            foreach($key as $arr)
            {
                $post = isset($this->requestData[$arr]) ? $this->requestData[$arr] : $default;
                $return[$arr] = $post;
            }
            return $return;
        }
        return isset($this->requestData[$key]) ? $this->requestData[$key] : $default;
    }

    /**
     * 合并数组并返回
     * @param type $values
     * @return type
     */
    public function merge($values)
    {
        return array_merge($this->retData, $values);
    }

    /**
     * 请求结束校验
     * @param  [type] $return 返回数据
     * @return [type]
     */
    public function message($return)
    {
        if (!isset($return['message']) || empty($return['message']))
        {
            $appMessage = Yii::t('app', $return['status']);
            if ($appMessage != $return['status'])
            {
                $return['message'] = $appMessage;
                return $return;
            }
            //接口model
			$message_file = APPROOT . DS . 'messages' . DS .\Yii::$app->language . DS . $this->apiData['controller'] . '.php';
			if (!file_exists($message_file))
			{
				Yii::$app->json->encode(['status' => -9, 'message' => \Yii::t('app', 'none_msg_file')]);
			}
			$controllerMessage = require_once $message_file;
            $message = $this->apiData['method'].'_'.$return['status'];
            if (isset($controllerMessage[$message]))
            {
                $return['message'] = $controllerMessage[$message];
                return $return;
            }
            $return['message'] = \Yii::t('app', 'success');
        }
        return $return;
    }

    /**
     * @desc 发送邮件
     * @param type $title
     * @param type $content
     * @param type $toEmail
     * @return type
     */
    public function sendmail($email,$title,$content)
    {
        $mail= Yii::$app->mailer->compose();
        $mail->setTo($email);
        $mail->setSubject($title);
        $mail->setTextBody($content);
        $mail->setHtmlBody($content);
        if($mail->send())
            return true;
        else
            return false;   
        die();
    }
}