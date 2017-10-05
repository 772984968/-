<?php
/**
 * @Copyright (C) 2014
 * @Author
 * @Version  Beta 1.0
 */
namespace lib\vendor\oauth;
/**
 * 微信登录
 */

class oauthWeixin
{
    public $appid = 'wxf16966b41ce1c317';
    public $appsecret = '8e2923c42a1b1c8a8b52ebbeda5662cb';
    public $redirectUrl = '';
    public $curl_timeout = 30;


    /**
     * 返回获取CODE URL
     * @param  string $state
     * @return string
     */
    public function getCodeUrl($state = 'STATE')
    {
        $urlObj["appid"]        = $this->appid;
        $urlObj["redirect_uri"] = $this->redirectUrl;
        $urlObj["response_type"]= "code";
        $urlObj["scope"]        = "snsapi_base";
        $urlObj["state"]        = $state;

        $url = "https://open.weixin.qq.com/connect/qrconnect?".$this->formatBizQueryParaMap($urlObj, false)."#wechat_redirect";
        return $url;
    }

    /**
     * 返回获取accesstoken url
     * @param  string $code
     * @return string
     */
    public function getAccessToken($code)
    {
        $urlObj["appid"]        = $this->appid;
        $urlObj["secret"]       = $this->appsecret;
        $urlObj["code"]         = $code;
        $urlObj["grant_type"]   = "authorization_code";
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?".$this->formatBizQueryParaMap($urlObj, false);
        
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($res, true);
        if (empty($data) || !isset($data['access_token']))
        {
            throw new CHttpException("向微信提交code获取access_token失败");
        }
        return $data;
    }

    /**
     * 获取用户信息
     * @param  [type] $access_token
     * @param  [type] $openid
     * @return [type]
     */
    public function getUserInfo($access_token, $openid)
    {
        $urlObj["access_token"] = $access_token;
        $urlObj["openid"]       = $openid;
        $url = 'https://api.weixin.qq.com/sns/auth?'.$this->formatBizQueryParaMap($urlObj, false);

        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res, true);
    }

    /**
     *  作用：格式化参数，签名过程需要使用
     */
    private function formatBizQueryParaMap($paraMap, $urlencode = false)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = "";
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }
}