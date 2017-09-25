<?php
namespace lib\vendor\alipaydirect;
/**
 * 微信支付配置
 */

class config
{
 
	//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
	//合作身份者id，以2088开头的16位纯数字
	 const partner		= "";// '2088302151378930';
	
	//收款支付宝账号，一般情况下收款账号就是签约账号
	const seller_email	= "";//'834911@qq.com';
	
	//安全检验码，以数字和字母组成的32位字符
	const key			= "";// 'nexzlomnqjyu2vaggdtf7jz7qk26xil8';
	//签名方式 不需修改
	const sign_type    = 'MD5';
	
	//字符编码格式 目前支持 gbk 或 utf-8
	const input_charset= 'utf-8';
	
	//ca证书路径地址，用于curl中ssl校验
	//请保证cacert.pem文件在当前文件夹目录中
	const cacert    = '\\cacert.pem';
	
	//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
	const transport    = 'http';

}
 
?>