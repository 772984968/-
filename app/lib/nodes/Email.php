<?php
namespace lib\nodes;
use Yii;
class Email{

    public static $code;
    private static $error;
    private static $message;
    private static $email;
    //发送邮件
    //return array: [state = 1 ]成功, [state=2] 邮件地址错误 [state=3]发送失败
    public static function send()
    {
        $mail= Yii::$app->mailer->compose();
        $mail->setTo(self::$email);
        $mail->setSubject(self::$message);
        //$mail->setTextBody('zheshisha ');   //发布纯文字文本
        //$mail->setHtmlBody(self::$message);    //发布可以带html标签的文本
        if($mail->send()){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 注册验证码
     * @param $email
     * @return mixed
     */
    public static function register($email)
    {
        self::$email = $email;
        self::create_rand();
        self::$message = '【艾特科技】'.self::$code.' 注册验证码。嘘！不要告诉其他人，这是我们的小秘密哦！';
        $result = self::send();
        return $result;

    }

    /**
     * 找回密码验证码
     * @param $email
     * @return mixed
     */
    public static function find($email)
    {
        self::$email = $email;
        self::create_rand();
        self::$message = '【艾特科技】'.self::$code.' 忘记密码验证码。我也爱追番，但是要注意饮食休息哦，下次别再忘记密码咯哟~';
        return self::send();
    }

    //创建随机验证码
    private static function create_rand()
    {
        self::$code = mt_rand(100000,999999);
    }


}