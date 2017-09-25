<?php
/**
 * @Copyright (C) 2015
 * @Author
 * @Version  5.0
 */

namespace app\components;

/**
 * API访问次数
 */
class ApiVist
{
    /**
     * 校验版本
     * @param $markInfo
     * @return array
     */
    public static function check_version($markInfo)
    {
        $version = strtolower($markInfo['version']);
        if (!in_array($markInfo['from'], array(1, 2, 3, 4)))
        {
            return array();
        }
        $appData = \lib\models\App::findOne(['type' => $markInfo['from'], 'status' => 1]);
        
        if (empty($version) || empty($appData))
        {
            return array('status' => -9, 'message' => '您的App未安装，请联系管理员');
        }
        if (!self::checkVersion($version, $appData->version)) {
            return array('status' => 2, 'remove' => $appData->remove, 'message' => '检测到更新，请重新下载并完成安装后使用');
        }
        return array();
    }

    /**
     * 版本校验
     * @param  [type] $thisversion 当前版本
     * @param  [type] $newversion  最新版本
     * @return bool
     */
    public static function checkVersion($thisversion, $newversion)
    {
        $thisV = explode(".", $thisversion);
        $newV = explode(".", $newversion);
        if (empty($thisV) || empty($newV)) {
            return false;
        }
        foreach ($thisV as $key => $val) {
            if (!isset($newV[$key]) || $val < $newV[$key]) {
                return false;
            }
        }
        return true;
    }

    /**
     * 获取Api访问次数
     * @param  [type] $apiName API名称
     * @return [type]          [description]
     */
    public static function getApivist($apiName)
    {
        return RedisComponent::getApivist($apiName);
    }

    /**
     * 校验Api访问次数
     * @param type $apiName
     * @param type $vistNum
     */
    public static function checkApivist($apiName, $vistNum)
    {
        $vistData = RedisComponent::getApivist($apiName);
        if (empty($vistData) || !is_array($vistData)) {
            RedisComponent::setApivist($apiName, array('num' => 1, 'close' => 0, 'start' => time()));
            return '';
        }
        $timeOut = time() - $vistData['time'];
        $timeStart = time() - $vistData['start'];
        $num = $vistData['num'] + 1;
        if ($vistData['close'] == 1) {
            if ($timeOut >= 3600) {
                RedisComponent::setApivist($apiName, array('num' => 1, 'close' => 0, 'start' => time()));
                return '';
            }
            return '您访问的速度太频繁，请稍后再访问';
        }
        if ($timeStart < 60) {
            if ($num > $vistNum) {
                return '您访问的速度太频繁，请稍后再访问';
            }
            if ($num == $vistNum) {
                $vistData['num'] = $num;
                $vistData['close'] = 1;
                $vistData['time'] = time();
                RedisComponent::setApivist($apiName, $vistData);
                return '';
            }
        }
        if ($timeStart >= 60) {
            RedisComponent::setApivist($apiName, array('num' => 1, 'close' => 0, 'start' => time()));
            return '';
        }
        $vistData['num'] = $num;
        $vistData['time'] = time();
        RedisComponent::setApivist($apiName, $vistData);
        return '';
    }
}