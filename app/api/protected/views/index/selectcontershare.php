<?php
use yii\helpers\Html;
USE yii\helpers\HtmlPurifier;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>为二次元用户创造价值的社交服务平台</title>
		<link rel="stylesheet" href="/assets/css/normalize.css" />
		<link rel="stylesheet" href="/assets/css/oun-pl.css" />
		<link rel="stylesheet" href="/assets/css/select-conter.css" />
		<link rel="stylesheet" href="/assets/css/head.css" />
		<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
	</head>
	<body>
		<div class="head-top">
			<div class="down-app">
				使用APP浏览
			</div>
		</div>
		<div class="select-wrap1">
			<div class="select-conter">
				<div>
					<p class="select-title"><?= Html::encode($info['title']) ?></p>
					<p class="secect-data"><span class="comment-dj-data"><?= date('Y-m-d H:i:s',$info->create_time) ?></span>
						<span class="comment-ly">
							<a href=""><?= Html::encode($info->author) ?></a>
						</span>
					</p>
				</div>
				<div class="text-diso">
					<?= $info->content ?>
				</div>
				<!--<div class="cstj">
					<p class="gkcs"><img src="/assets/images/eye_16.png" alt="" /><span><?= Html::encode($info->look_number) ?></span></p>
					<p class="dzcs"><img src="/assets/images/love_19.png" alt="" /><span><?= Html::encode($info->praise_number) ?></span></p>
				</div>-->
				

			</div>
			
			   	<div class="oun-pl-wrap dz-tab" id="articleComment">

               
       	 		</div>
		</div>
     
       
	</body>
	<script src="/assets/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="/assets/js/size.js"></script>
	<script type="text/javascript" src="/assets/js/selectpl.js"></script>
	<script>
		
	var id = '<?= intval(\Yii::$app->request->get('id')) ?>';
	var token = '<?= \YII::$app->request->get('token') ?>';
	var userid = '<?= \YII::$app->request->get('userid') ?>';
		$.get("/recommend/commentlist?id="+id+"&page=1&pagesize=3&token="+token+"&userid="+userid+"",function  (data) {
			if(data.code == 200) {
				$(".oun-pl-wrap").css({background:"#fff"})
				var agoComment=data.data
				$("#articleComment").zyComment({
					"agoComment":agoComment
				});
				var y=1
				$(window).scroll(function  () {if (Math.ceil($(window).scrollTop())>= Math.ceil($(document).height()-$(window).height())) {
						y++;
						$.get("/recommend/commentlist?id="+id+"&page="+y+"&pagesize=3&token="+token+"&userid="+userid+"",function  (data) {
							if(data.code == 200) {
							var agoComment=data.data;
							$("#articleComment").zyComment({"agoComment":agoComment});	
							}
							
						})}
				})
			}
			else if(data.code == 404){
				console.log("没有数据")
				return false;
			}
			
		})

	</script>
</html>
