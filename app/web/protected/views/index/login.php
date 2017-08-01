<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>次元纪 - 让次元连接你们</title>
		<link rel="shortcut icon" href="/assets/images/erci.ico" type="image/x-icon">		
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<!--<link rel="stylesheet" type="text/css" href="/assets/css/normalize.css"/>-->
		<link rel="stylesheet" href="/assets/css/upload.css" />
		<link rel="stylesheet" href="/assets/css/webuploader.css" />
		<style type="text/css">

		</style>
	</head>
	<body style="overflow: hidden;">
			<div class="upload-wrap">
				<div class="upload-head">
					<p>
						<img src="/assets/images/lll_02.png"/>
						<span><a href="/index/index">首页</a></span>
						<strong class="tg">投稿</strong>
					</p>
				</div>
				<div class="login-wrap">
					<div class="login-dl">
						<p class="ahhh-wrap">
							<span></span><input type="text"  class="ahhh" placeholder="邮箱/手机号">
						</p>
						<p class="xi"></p>
						<p class="abbb-wrap">
							<span></span><input type="password"  class="abbb" placeholder="密码">
						</p>
						<!--<p><span>忘记密码？</span><span>获取验证码</span></p>-->
						<p class="aaannn">登录</p>
					</div>
				</div>
			</div>
	</body>
	<script src="/assets/js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/js/uploadpage.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/js/webuploader.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/js/jqmeter.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/layer/layer.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
	$(".aaannn").click(function  () {
		if ($(".ahhh").val()=="") {
			layer.msg('邮箱或手机号不能为空', function(){
				$(".ahhh").focus()
			});
			return false;
		}
	
		if ($(".abbb").val()=="") {
			layer.msg('密码不能为空', function(){
				$(".abbb").focus()
			});
			return false;
		}
		var LoginForm={}
		LoginForm['name']=$(".ahhh").val()
		LoginForm['password']=$(".abbb").val()
		var json = {LoginForm};
		$.post("/login/login",json,function  (data) {
			console.log(data)
				if (data.message=="用户名或密码错误!") {layer.msg('用户名或密码错误', function(){$(".ahhh").focus()})}
				if (data.message=="ok") {
					layer.msg('登录成功');
					window.location.href="/index/upload"
				}
				
				
			
		})
	})
	

	
	

	</script>
</html>	