<?php
	use yii\helpers\Html; //636
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>为二次元用户创造价值的社交服务平台</title>
		<link rel="stylesheet" type="text/css" href="/assets/css/homepage.css"/>
		<link rel="stylesheet" type="text/css" href="/assets/css/normalize.css"/>
		<link rel="stylesheet" href="/assets/css/workes.css" />
		<link rel="stylesheet" href="/assets/css/head.css" />
		
		<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
		
	</head>
	<body>
		<div class="head-top">
			<div class="down-app">
				使用APP浏览
			</div>
		</div>
		<div class="home-wrap">
			<div class="home-head" <?php if($result['icon']):?> style="background:url('<?= html::encode($result['icon'])?>') no-repeat; background-size:100% 100%;"  "<?php endif;?>>
				<p class="home-img"><span><img src="<?php if($result['icon']):?><?= html::encode($result['icon']) ?> <?php else: ?>/assets/images/home_02.jpg<?php endif;?>" alt="" /></span></p>
				<p class="home-name">
						<span><?= html::encode($result['nickname']) ?></span>
						<?php if($result['sex']=='男'): ?>
							<img src="/assets/images/hoxb_03.png" alt="" />
						<?php else: ?>
							<img src="/assets/images/20170414113228.png" alt="" />
						<?php endif;?>
				</p>
				<p class="home-sf"><span><?= html::encode($result['status']) ?></span></p>
				<p class="home-xx"><span><?= html::encode($result['site']) ?></span><span><?= html::encode($result['height']) ?>cm</span><span><?= html::encode($result['weight']) ?>KG</span></p>
				<p class="home-js"><?= html::encode($result['intro']) ?></p>
				<p class="home-j"><span>编辑</span></p>
			</div>
			<div class="zpq">
				<p class="ccc">照片墙<span class="aaa"><img src="/assets/images/mo.png"/></span></p>
				<div class="zpq-img">
					<div>

					</div>
					
				</div>
			</div>
			<div class="zjzp">
				<p class="ccc">推荐作品<span class="bbb">+</span></p>
				<div class="zp-home home-none"></div>
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
	<script>
		var id = '<?= intval(\Yii::$app->request->get('id')) ?>';
		var token = '<?= \YII::$app->request->get('token') ?>';
		var userid = '<?= \YII::$app->request->get('userid') ?>';

		$(window).load(function  () {
			$.get("/center/cardimagelist?user="+id+"&page&pagesize&token="+token+"&userid="+userid+"",function  (data) {
					if (data.code==200) {
						console.log(data)
						var zpq='';
						for ( i in data.data) {
							for (a in data.data[i].images) {
								
							}
							zpq+='<img src="'+data.data[i].images[0].thumb+'" alt="" />';
						}
						$(".zpq-img div").append(zpq)	
					}
				})

				
				
				
				$.get("/product/ownlist?user="+id+"&circle&product&token="+token+"&userid="+userid+"",function  (data) {
					if (data.code==200) {
						window.product_minid=data.data.product_minid;
						window.circle_minid=data.data.circle_minid;
						var zp='';
						for ( i in data.data.data) {
							zp+='<div class="zp-home-center"><p class="zp-title">'+data.data.data[i].title+'</p>';
							zp+='<p class="zp-img"><img src="'+data.data.data[i].images[0].thumb+'" alt="" /></p>';
							zp+='<p class="zp-dz"><span>'+data.data.data[i].praise_number+'</span><span>'+data.data.data[i].comment_number+'</span></p></div>';
						}
						$(".zp-home").append(zp)	
					}
					
				})
				$(window).scroll(function  () {
					
				if (Math.ceil($(window).scrollTop())>= Math.ceil($(document).height()-$(window).height())) {
					
					$.get("/product/ownlist?user="+id+"&circle="+circle_minid+"&product="+product_minid+"&token="+token+"&userid="+userid+"",function  (data) {
						if(data.code == 200) {
							if (product_minid==data.data.product_minid && circle_minid ==data.data.circle_minid) {
								return false;
								console.log("aaaa")
							}
							window.product_minid=data.data.product_minid
							window.circle_minid=data.data.circle_minid
							console.log(product_minid)
							if (data.message=="没有数据") {
								return false;
							}
							var zp2='';
							for ( i in data.data.data) {
								zp2+='<div class="zp-home-center"><p class="zp-title">'+data.data.data[i].title+'</p>';
//								for (a in data.data.data[i].images) {
										zp2+='<p class="zp-img"><img src="'+data.data.data[i].images[0].thumb+'" alt="" /></p>';
//								}
								zp2+='<p class="zp-dz"><span>'+data.data.data[i].praise_number+'</span><span>'+data.data.data[i].comment_number+'</span></p></div>';
							}
							$(".zp-home").append(zp2)	

						} else if(data.code == 404) {
							console.log('没有数据');
						}
					})
				}
				
				})
		})
	</script>
</html>
