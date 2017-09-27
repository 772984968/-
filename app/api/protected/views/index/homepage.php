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
				<p class="home-j"><span><?php if($result['concern']): ?>-关注<?php else:?>+关注<?php endif;?></span></p>
			</div>
			<ul class="home-tab">
				<li class="tab-select"><span>身份</span></li>
				<li><span>作品</span></li>
				<li><span>点赞</span></li>
			</ul>

			<div class="sf-home home-none"> 
				<p class="home-w">我的身份</p>
				
				

			</div>
			<div class="zp-home home-none" style="display: none;">
				
				
			
			</div>
			<div class="dz-home home-none" style="display: none;">
				<ul class="tab-ul">
					<li class="yellow-home cos">COS</li>
					<li class="hyy">绘画</li>
					<li class="wdd">舞蹈</li>
					<li class="yyy">音乐</li>
					<li class="sff">身份</li>
				</ul>
				<div class="dz-tab dz-width dz-cos">
					<div class="dz-img dz-coss"></div>	
				</div>
				<div class="dz-tab dz-width dz-hh" style="display: none;">
					<div class="dz-img dz-hyy"></div>
				</div>
				<div class="dz-tab dz-width dz-wd" style="display: none;"></div>
				<div class="dz-tab dz-width dz-yy" style="display: none;"></div>
				<div class="dz-tab dz-width dz-sf" style="display: none;"></div>
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
		$(".home-tab li").click(function  () {
			$(this).addClass("tab-select").siblings().removeClass("tab-select")
			var i=$(this).index()
			$(".home-none").eq(i).show().siblings(".home-none").hide()
		})
		$(".tab-ul li").click(function  () {
			$(this).addClass("yellow-home").siblings().removeClass("yellow-home")
			var i=$(this).index()
			$(".dz-tab").eq(i).show().siblings(".dz-tab").hide()
		})
		$(window).load(function  () {
			$.get("/user/status?user="+id+"&page=1&token="+token+"&userid="+userid+"",function  (data) {
				 
				
				for (var i in data.data)
						{
							var sf='';
							sf+='<div class="home-cont">';
									sf+='<div class="backpic-wrap">';
										sf+='<div class="backpic-user">';
											sf+='<a href=""><img src="'+data.data[i].icon+'" alt=""></a>';
										sf+='</div>';
										sf+='<div class="back-data">';
											sf+='<p>'+data.data[i].nickname+'</p>';
											switch (data.data[i].status){
												case "1": 
												window.status="cos"
												break;
												case "2": 
												window.status="化妆师"
													break;
												case "3": 
												window.status="道具师"
													break;
												case "4": 
												window.status="二手买卖"
													break;
												case "5": 
												window.status="摄影师"
													break;
												case "6": 
												window.status="后期师"
													break;
												case "7": 
												window.status="工作室"
													break;
												case "8": 
												window.status="裁缝师"
													break;
											}
											
											sf+='<p>'+status+'</p>';
										sf+='</div>';
										sf+='<div class="back-hack">';
											sf+='<a href="/assets/">';
												sf+='<span>&yen;'+data.data[i].money+'</span>';
											sf+='</a>';
										sf+='</div>';
									sf+='</div>';
									sf+='<div>';
										sf+='<a href="/assets/">';
											sf+='<ul class="ba-photo">';
													for (var a in data.data[i].images){
														sf+='<li><img src="/assets/images/img_03.png" alt=""></li>';
													}
											sf+='</ul>';
										sf+='</a>';
										sf+='<p class="back-title">'+data.data[i].content+'</p>';
									sf+='</div>';
									sf+='<div class="bi">';
									sf+='<span class="biao-map">'+data.data[i].city+'</span>';
									sf+='<a href="/assets/"><span class="biao-yl">'+data.data[i].comment_number+'</span></a>';
								sf+='</div>';
							sf+='</div>';
							$(".sf-home").append(sf)
						}
			})
			//===========获取点赞里的cos==============
			$.get("/praise/cos?user="+id+"&page=1&token="+token+"&userid="+userid+"",function  (data) {
				 
				var cos=""
				if (data.code==200) {
					for (i in data.data) {
						cos+='<img src="'+data.data[i].side_image+'" alt="">'
					}
					$(".dz-coss").append(cos)
				}
				
				var b=1
				$(window).scroll(function  () {
				
				if (Math.ceil($(window).scrollTop())>= Math.ceil($(document).height()-$(window).height())) {
					b++;
					var cos2=""
						$.get("/praise/cos?user="+id+"&page="+b+"&token="+token+"&userid="+userid+"",function  (data) {
						
						for (i in data.data) {
							if (data.code==200) {
									cos2+='<img src="'+data.data[i].side_image+'" alt="">'
									$(".dz-img").append(cos2)
								}
							
							}
	
						})

					}
				})
			})
			
			
			//===========获取点赞里的绘画==============
				$.get("/praise/wrawing?user="+id+"&page=1&token="+token+"&userid="+userid+"",function  (data) {
				 
				var hyy=""
				if (data.message=="没有数据") {
					return false;
				}
				for (i in data.data) {
						hyy+='<img src="'+data.data[i].side_image+'" alt="">'
					}
				$(".dz-hyy").append(hyy)
				var b=1
				$(window).scroll(function  () {
				
				if (Math.ceil($(window).scrollTop())>= Math.ceil($(document).height()-$(window).height())) {
					b++;
					var hyy2=''
						$.get("/praise/wrawing?user="+id+"&page="+b+"&token="+token+"&userid="+userid+"",function  (data) {
						
						for (i in data.data) {
							if (data.message=="没有数据") {
								return false
							}
							hyy2+='<img src="'+data.data[i].side_image+'" alt="">'
							$(".dz-hyy").append(hyy2)
							}
	
							})
	
						}
					})
				})
			
			
			//===========获取点赞里的舞蹈==============
				$.get("/praise/dance?user="+id+"&page=1&pagesize=6&token="+token+"&userid="+userid+"",function  (data) {
					 
					var wd=""
					if (data.message=="没有数据") {
						return false;
					}
					for (i in data.data) {
							wd+='<div class="video-list">';
								wd+='<div class="list-left"><img src="'+data.data[i].long_image+'" alt="" /></div>';
								wd+='<div class="list-right">';
									wd+='<p>'+data.data[i].title+'</p>';
									wd+='<p>'+data.data[i].nickname+'</p>';
									wd+='<p><span><span>'+data.data[i].look_number+'</span>次播放</span><span class="pl-s">'+data.data[i].comment_number+'</span></p>';
								wd+='</div>';
							wd+='</div>';
						}
					$(".dz-wd").append(wd)
				})
				//===========================================
				var b=1
				$(window).scroll(function  () {
				if (Math.ceil($(window).scrollTop())>= Math.ceil($(document).height()-$(window).height())) {
					b++;
					$.get("/praise/dance?user="+id+"&page="+b+"&pagesize=6&token="+token+"&userid="+userid+"",function  (data) {
					 
					var wd2=""
					if (data.code==200) {
						for (i in data.data) {
							wd2+='<div class="video-list">';
								wd2+='<div class="list-left"><img src="'+data.data[i].long_image+'" alt="" /></div>';
								wd2+='<div class="list-right">';
									wd2+='<p>'+data.data[i].title+'</p>';
									wd2+='<p>'+data.data[i].nickname+'</p>';
									wd2+='<p><span><span>'+data.data[i].look_number+'</span>次播放</span><span class="pl-s">'+data.data[i].comment_number+'</span></p>';
								wd2+='</div>';
							wd2+='</div>';
						}
					$(".dz-wd").append(wd2)
			
					}
					
					})
					}
				})
				//===========================================
			
			
			//====================获取我点赞的音乐=======================
			
				$.get("/praise/music?user="+id+"&page=1&pagesize=6&token="+token+"&userid="+userid+"",function  (data) {
					 
					var wd=""
					if (data.code==200) {
						for (i in data.data) {
							wd+='<div class="video-list">';
								wd+='<div class="list-left"><img src="'+data.data[i].long_image+'" alt="" /></div>';
								wd+='<div class="list-right">';
									wd+='<p>'+data.data[i].title+'</p>';
									wd+='<p>'+data.data[i].nickname+'</p>';
									wd+='<p><span><span>'+data.data[i].look_number+'</span>次播放</span><span class="pl-s">'+data.data[i].comment_number+'</span></p>';
								wd+='</div>';
							wd+='</div>';
						}
					$(".dz-yy").append(wd)
					}
					
				})
				//===========================================
				var b=1
				$(window).scroll(function  () {
				if (Math.ceil($(window).scrollTop())>= Math.ceil($(document).height()-$(window).height())) {
					b++;
					$.get("/praise/music?user="+id+"&page="+b+"&pagesize=6&token="+token+"&userid="+userid+"",function  (data) {
					 
					var wd2=""
					if (data.code==200) {
						for (i in data.data) {
							wd2+='<div class="video-list">';
								wd2+='<div class="list-left"><img src="'+data.data[i].long_image+'" alt="" /></div>';
								wd2+='<div class="list-right">';
									wd2+='<p>'+data.data[i].title+'</p>';
									wd2+='<p>'+data.data[i].nickname+'</p>';
									wd2+='<p><span><span>'+data.data[i].look_number+'</span>次播放</span><span class="pl-s">'+data.data[i].comment_number+'</span></p>';
								wd2+='</div>';
							wd2+='</div>';
						}
					$(".dz-yy").append(wd2)
					}
					
			
					})
					}
				})
				//===========================================
			
			
			
			//===========================================
			
			
			
			
			//===============获取我点赞的身份============================
			//===========================================
			
				$.get("/praise/status?user="+id+"&page=1&pagesize=6&token="+token+"&userid="+userid+"",function  (data) {
				 console.log(data)
				for (var i in data.data)
						{
							var sf='';
							sf+='<div class="home-cont">';
									sf+='<div class="backpic-wrap">';
										sf+='<div class="backpic-user">';
											sf+='<a href="/assets/"><img src="'+data.data[i].icon+'" alt=""></a>';
										sf+='</div>';
										sf+='<div class="back-data">';
											sf+='<p>'+data.data[i].nickname+'</p>';
											switch (data.data[i].status){
												case "1": 
												window.status="cos"
												break;
												case "2": 
												window.status="化妆师"
													break;
												case "3": 
												window.status="道具师"
													break;
												case "4": 
												window.status="二手买卖"
													break;
												case "5": 
												window.status="摄影师"
													break;
												case "6": 
												window.status="后期师"
													break;
												case "7": 
												window.status="工作室"
													break;
												case "8": 
												window.status="裁缝师"
													break;
											}
											
											sf+='<p>'+status+'</p>';
										sf+='</div>';
										sf+='<div class="back-hack">';
											sf+='<a href="/assets/">';
												sf+='<span>&yen;'+data.data[i].money+'</span>';
											sf+='</a>';
										sf+='</div>';
									sf+='</div>';
									sf+='<div>';
										sf+='<a href="/assets/">';
											sf+='<ul class="ba-photo">';
													for (var a in data.data[i].images){
														sf+='<li><img src="/assets/images/img_03.png" alt=""></li>';
													}
											sf+='</ul>';
										sf+='</a>';
										sf+='<p class="back-title">'+data.data[i].content+'</p>';
									sf+='</div>';
									sf+='<div class="bi">';
									sf+='<span class="biao-map">'+data.data[i].city+'</span>';
									sf+='<a href="/assets/"><span class="biao-yl">'+data.data[i].comment_number+'</span></a>';
								sf+='</div>';
							sf+='</div>';
							$(".dz-sf").append(sf)
						}
			})
				var b=1
				$(window).scroll(function  () {
				if (Math.ceil($(window).scrollTop())>= Math.ceil($(document).height()-$(window).height())) {
					b++;
					$.get("/praise/status?user="+id+"&page="+b+"&pagesize=6&token="+token+"&userid="+userid+"",function  (data) {
				
					var sf=""
					if (data.message=="没有数据") {
						return false;
					}
					for (var i in data.data)
						{
							var sf='';
							sf+='<div class="home-cont">';
									sf+='<div class="backpic-wrap">';
										sf+='<div class="backpic-user">';
											sf+='<a href="/assets/"><img src="'+data.data[i].icon+'" alt=""></a>';
										sf+='</div>';
										sf+='<div class="back-data">';
											sf+='<p>'+data.data[i].nickname+'</p>';
											switch (data.data[i].status){
												case "1": 
												window.status="cos"
												break;
												case "2": 
												window.status="化妆师"
													break;
												case "3": 
												window.status="道具师"
													break;
												case "4": 
												window.status="二手买卖"
													break;
												case "5": 
												window.status="摄影师"
													break;
												case "6": 
												window.status="后期师"
													break;
												case "7": 
												window.status="工作室"
													break;
												case "8": 
												window.status="裁缝师"
													break;
											}
											
											sf+='<p>'+status+'</p>';
										sf+='</div>';
										sf+='<div class="back-hack">';
											sf+='<a href="/assets/">';
												sf+='<span>'+data.data[i].money+'</span>';
											sf+='</a>';
										sf+='</div>';
									sf+='</div>';
									sf+='<div>';
										sf+='<a href="/assets/">';
											sf+='<ul class="ba-photo">';
													for (var a in data.data[i].images){
														sf+='<li><img src="/assets/images/img_03.png" alt=""></li>';
													}
											sf+='</ul>';
										sf+='</a>';
										sf+='<p class="back-title">'+data.data[i].content+'</p>';
									sf+='</div>';
									sf+='<div class="bi">';
									sf+='<span class="biao-map">'+data.data[i].city+'</span>';
									sf+='<a href="/assets/"><span class="biao-yl">'+data.data[i].comment_number+'</span></a>';
								sf+='</div>';
							sf+='</div>';
							$(".dz-sf").append(sf)
						}
					})
					}
				})
			//===========================================
				$.get("/product/ownlist?user="+id+"&circle&product&token="+token+"&userid="+userid+"",function  (data) {
					if (data.code==200) {
						window.product_minid=data.data.product_minid;
						window.circle_minid=data.data.circle_minid;
						var zp='';
						for ( i in data.data.data) {
							zp+='<div class="zp-home-center"><p class="zp-title">'+data.data.data[i].title+'</p>';
	//						for (a in data.data.data[i].images) {
									zp+='<p class="zp-img"><img src="'+data.data.data[i].images[0].thumb+'" alt="" /></p>';
	//						}
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
