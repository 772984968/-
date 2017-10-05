<?php
namespace lib\vendor\alipaydirect;
// require_once("alipay.config.php");

// require_once("lib/alipay_submit.class.php");
// require_once("config.php");
class alipayapi{
/**************************请求参数**************************/
	public $params ;
	public $payment_type ;
	public $notify_url ;
	public $return_url ;
	public $out_trade_no ;
	public $subject ;
	public $total_fee ;
	public $body ;
	public $show_url ;
	public $anti_phishing_key ;
	public $exter_invoke_ip;
	/**
	 * 析构函数
	 */
	public function __construct($data)
	{
        //支付类型
        $this->payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $this->notify_url = "http://web.kake.rhy.com/order/notify_url";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $this->return_url = "http://web.kake.rhy.com/order/index";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //商户订单号
        $this->out_trade_no = $data['out_trade_no'];
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $this->subject = $data['subject'];
        //必填

        //付款金额
        $this->total_fee = $data['total_fee'];
        //必填

        //订单描述

        $this->body = $data['body'];
        //商品展示地址
        $this->show_url = $data['show_url'];
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //防钓鱼时间戳
        $this->anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $this->exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1
        //构造要请求的参数数组，无需改动
        $this->parameter = array(
        		"service" => "create_direct_pay_by_user",
        		"partner" => trim(config::partner),
        		"seller_email" => trim(config::seller_email),
        		"payment_type"	=> $this->payment_type,
        		"notify_url"	=> $this->notify_url,
        		"return_url"	=> $this->return_url,
        		"out_trade_no"	=> $this->out_trade_no,
        		"subject"	=> $this->subject,
        		"total_fee"	=> $this->total_fee,
        		"body"	=> $this->body,
        		"show_url"	=> $this->show_url,
        		"anti_phishing_key"	=> $this->anti_phishing_key,
        		"exter_invoke_ip"	=> $this->exter_invoke_ip,
        		"_input_charset"	=> trim(strtolower(config::input_charset))
        );

	}
/************************************************************/

	public function getpayurl(){
	//建立请求

		require_once("lib/alipay_submit.class.php");
		$alipaySubmit = new \AlipaySubmit($this->getaliPayParams());

		$html_text = $alipaySubmit->buildRequestForm($this->parameter,"get", "确定");
		return $html_text;
	}
	/**
	 * 设置aliapi的参数
	 * @return string
	 */
	public function getaliPayParams()
	{
		$time = time();
		$aliApi['partner']     = config::partner;
		$aliApi['seller_email'] = config::seller_email;
		$aliApi['key']  = config::key;
		$aliApi['sign_type']   = strtoupper(config::sign_type);
		$aliApi['input_charset']  = strtolower(config::input_charset);
		$aliApi['cacert']   = getcwd().config::cacert;
		$aliApi['transport']   = config::transport;
		return $aliApi;
	}
}

