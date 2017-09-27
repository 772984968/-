<?php
	use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>为二次元用户创造价值的社交服务平台</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" type="text/css" href="/assets/css/mui.min.css"/>
		<link rel="stylesheet" type="text/css" href="/assets/css/normalize.css"/>
		<link rel="stylesheet" type="text/css" href="/assets/css/huati.css"/>
		<link rel="stylesheet" type="text/css" href="/assets/css/oun-pl.css"/>
		<link rel="stylesheet" href="/assets/css/select-conter.css" />
		<link rel="stylesheet" href="/assets/css/head.css" />
		
		

	</head>
	<body>
		<div style="width: 10rem; margin: 0 auto;">
			
		
	<div class="head-top">
			<div class="down-app">
				使用APP浏览
			</div>
		</div>
	<div class="select-wrap1">
			<div class="workes-wrap">
				<p class="worke-title"><?= Html::encode($info['title']) ?></p>
				<p class="worke-title-fu"><?= Html::encode($info['content']) ?></p>
			</div>
			<div class="mui-content-padded">
				<?php foreach($info['images'] as $row): ?>
					<p class="worke-img"><img src="<?= Html::encode($row->source) ?>" data-preview-src="" data-preview-group="1"></p>
				<?php endforeach; ?>
			</div>
			<div class="oun-pl-wrap" id="articleComment">
				
			</div>
	</div>
		<div class="head-bottom">
			<div class="down-open">
				马上下载
			</div>
		</div>】
		</div>
	</body>
	<script type="text/javascript" src="/assets/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="/assets/js/mui.min.js"></script>
	<script src="/assets/js/sharesize.js" type="text/javascript"></script>
	<script type="text/javascript" src="/assets/js/mui.zoom.js"></script>
	<script src="/assets/js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="/assets/js/mui.previewimage.js"></script>
	<script src="/assets/js/htpl.js" type="text/javascript" charset="utf-8"></script>
	<script>
		var id = '<?= intval(\Yii::$app->request->get('id')) ?>';
		var token = '<?= \YII::$app->request->get('token') ?>';
		var userid = '<?= \YII::$app->request->get('userid') ?>';
		mui.previewImage();
		$.get("/circle/commentlist?id="+id+"&page=1&pagesize=3&token="+token+"&userid="+userid+"",function  (data) {
			if(data.code == 200) {
				$(".oun-pl-wrap").css({background:"#fff"})
				var agoComment=data.data
				$("#articleComment").zyComment({
					"agoComment":agoComment
				});
				var y=1
				$(window).scroll(function  () {if (Math.ceil($(window).scrollTop())>= Math.ceil($(document).height()-$(window).height())) {
						y++;
						$.get("/circle/commentlist?id="+id+"&page="+y+"&pagesize=3&token="+token+"&userid="+userid+"",function  (data) {
							var agoComment=data.data;
							$("#articleComment").zyComment({"agoComment":agoComment});})}
				})
			}
			else if(data.code == 404){
				console.log("没有数据")
				return false;
			}
			
		})
		
		
	</script>
</html>
