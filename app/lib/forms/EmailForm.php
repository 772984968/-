<?php
namespace lib\forms;
use Yii;

//邮件验证码表单

class EmailForm extends CaptchaForm
{
    public $username;                           //帐号
    public $validMinute = 5;                    //短信有效时间(分钟)
    public $sendClass = '\lib\nodes\Email';
    //缓存的关键字
    const REGISTER_NAME = 'register_email_';      //注册记录【缓存名称】
    const FIND_NAME = 'find_email_';              //查找密码记录【缓存名称】
    const FIND_CODE = 'find_email_code_';             //找回密码验证码【缓存名称】
    const FIND_CODE_ERROR = 'find_email_code_error_'; //找回密码短信验证码错误 【缓存名称】
    const REGISTER_IP = 'register_email_ip';      //请求IP记录 【缓存名称】
    const REGISTER_CODE = 'register_email_code_'; //注册验证码 【缓存名称】
    const REGISTER_CODE_ERROR = 'register_email_code_error_'; //注册验证码错误名称

}
