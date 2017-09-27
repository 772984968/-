<?php
	use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>为二次元用户创造价值的社交服务平台</title>
		<link rel="stylesheet" type="text/css" href="/assets/css/normalize.css"/>
		<link rel="stylesheet" type="text/css" href="/assets/css/video.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no" />
		<meta name="renderer" content="webkit">
		<link rel="stylesheet" href="/assets/css/head.css" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	</head>
	<body>
		<div class="head-top">
			<div class="down-app">
				使用APP浏览
			</div>
		</div>
		<div class="video-wrap">
			<div></div><!--打开app-->
			<div id="mediaplayer"></div> 
			<ul class="video-tab">
				<li class="video-select"><span>简介</span></li>
				<li><span>评论</span></li>
			</ul>
			<div class="video-conter">
				<p class="video-title"><?= Html::encode($result['title']) ?></p>
				<ul class="video-fu">
					<li><?= Html::encode($result['content']) ?></li>
					<!--<li>如果被大家喜欢是一件非常荣幸的事。</li>
					<li>这支舞主要是送给我的好朋友七信。祝你十九岁生日快乐。</li>
					<li>愿你前方路途尽是荣光。</li>-->
				</ul>
				<p class="video-ll"><span><?= Html::encode($result['look_number']) ?></span>次播放</p>
				<div class="video-down-wrap">
					<ul class="voide-down">
						<li><span><?= Html::encode($result['turn_number']) ?></span></li>
						<li><span><?= Html::encode($result['praise_number']) ?></span></li>
						<li><span><?= Html::encode($result['down_number']) ?></span></li>
					</ul>
				</div>
				
				<div class="voide-name">
					<div class="voide-img">
						<img src="<?= Html::encode($result['icon']) ?>" alt="" />
					</div>
					<div>
						<p class="video-name"><?= Html::encode($result['nickname']) ?></p>
						<p class="video-time"><?= intval((time()-$result['create_time'])/(3600*24)) ?>天前投稿</p>
					</div>
					<span class="video-gz">关注</span>
				</div>
				<p class="video-m">视频相关</p>
				<p class="video-baqn">
					<?php foreach($result['labels'] as $row): ?>
						<span><?= Html::encode($row['name']) ?></span>
					<?php endforeach; ?>
				</p>
				<div class="video-list-wrap">
					<?php foreach($result['about'] as $row): ?>
						<div class="video-list">
						<div class="list-left"><img src="<?= Html::encode($row['side_image']) ?>" alt="" /></div>
						<div class="list-right">
							<p><?= $row['title'] ?></p>
							<p><?= $row['nickname'] ?></p>
							<p><?= $row['look_number'] ?>次播放</p>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			
		</div>
		<div class="head-bottom">
			<div class="down-open">
				马上下载
			</div>
		</div>
	</body>
	<script src="/assets/js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/js/size.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/jwplayer/jwplayer.js"></script>
	<script src="/assets/jwplayer/jwpsrv.js"></script>
	<script type="text/javascript">
		jwplayer('mediaplayer').setup({
		    'flashplayer': '/assets/jwplayer/jwplayer.flash.swf',
			'image': '<?= Html::encode($result['side_image']) ?>',
		    'id': 'playerID',
		    'width': '100%',
			'aspectratio':'10:6',
		    'file': '<?= Html::encode($result['video']) ?>'
		 });
	</script>
</html>
