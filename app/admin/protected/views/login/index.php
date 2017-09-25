<?php

use yii\helpers\Url;
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\web\request;
use yii\captcha\Captcha;

$this->title = '卡客后台管理系统-登录';
?>
<style type="text/css">html,body{background: #e1e1e1;}</style>
<div class="dux-login">
	<div class="media media-y">
		<a href="#" target="_blank"><img src="<?=yii::$app->params['url']['staticUrl']?>images/logo.png" alt="后台管理系统" /></a>
	</div>                        
	<br /><br />
	<?php echo html::beginForm('', 'Post', array('id' => 'admin_login'));?>
	<div class="input-block">
		<input type="text" class="input" id="username" name="username" size="20" maxlength="30" placeholder="用户名" limit="required:true" msg="用户名不能为空" title="请填写正确登录账号" msgArea="try_info" />
		<span class="bc b_user"></span>
		<input type="password" class="input" id="password" name="password" size="20" maxlength="30" placeholder="密码" limit="required:true" msg="密码不能为空" title="请填写正确密码" msgArea="try_info" />
		<span class="bc b_pass"></span>
		<input type="text" class="input" id="captcha" name="captcha" size="6" maxlength="6" placeholder="验证码" limit="required:true" msg="验证码不能为空" title="请填写验证码" msgArea="try_info" style="width:140px;float:left;" />
		<span class="bc b_pass"></span>
		<?php echo Captcha::widget(['captchaAction' => 'login/captcha', 'name' => 'captcha', 'template' => '{image}', 'imageOptions' => ['class' => 'captcha','title' => '看不清楚？点击切换']]);?>
	</div>
	<br>
	<div class="form-group">
		<button type="submit" class="button button-block bg-main text-big">登录</button> 
	</div>
	<p class="loginform error">
		<span id="try_info" <?php if(isset($error)):?>class="msg msg_error" <?php endif;?>><span><?php echo isset($error) ? $error : '';?></span></span>
	</p>
	<?php echo html::endForm();?>
</div>