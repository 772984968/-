<?php
	namespace lib\nodes;
	//蓝创短信
	class Note extends \yii\base\Component
	{
		private static $code;
		public static $error;
		private static $message;
		private static $mobile;

		//发送短信验证码
		private static function send()
		{
			require \Yii::$app->basePath.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'smsconfig.php';
			// 发送单条短信
			$smsOperator = new \lib\sms\SmsOperator();
			$data['mobile'] = self::$mobile;
			$data['text'] = str_replace('{code}', self::$code, self::$message);;
			$result = $smsOperator->single_send($data);

			if( $result->success ) {
				return true;
			} else {
				self::$error = $result->responseData['msg'];
				return false;
			}
		}

		//发送短信注册验证码
		public static function register($mobile)
		{
				self::$mobile = $mobile;
				self::$message = '{code} 注册验证码。嘘！不要告诉其他人，这是我们的小秘密哦！';
				self::create_rand();
				return self::send();
		}

		//登入短信验证码
		public static function login($mobile)
		{
			self::$mobile = $mobile;
			self::$message = '登录验证码{code}。为了你的安全，请不要随意告诉陌生人验证码，因为...你有可能被陌生人胖揍！';
			self::create_rand();
			return self::send();
		}

		//找回密码短信验证码
		public static function findpass($mobile)
		{
			self::$mobile = $mobile;
			self::$message = '{code} 忘记密码验证码。我也爱追番，但是要注意饮食休息哦，下次别再忘记密码咯哟~';
			self::create_rand();
			return self::send();
		}

		//创建随机验证码
		private static function create_rand()
		{
			self::$code = mt_rand(100000,999999);
		}



		//取随机验证码
		public static function getcode()
		{
			return self::$code;
		}
	}


?>