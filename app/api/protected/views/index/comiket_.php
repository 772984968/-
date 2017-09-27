<?php
	use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/assets/css/normalize.css" />
		<link rel="stylesheet" href="/assets/css/Comiket.css" />
		<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
	</head>
	<body>
		
		<div class="Comiket-wrap">
			<div class="Comiket-title">
				<div class="Comiket-title-left">
					<img src="/assets/images/Comiket_02.png" alt="" />
				</div>
			
				<div class="Comiket-title-right">
					<p class="Comiket-title-right-title"><?= Html::encode($result['title']) ?></p>
					<p class="Comiket-title-right-data"> <?= Html::encode($result['dt']) ?><?php if($result['end_dt']):?>——<?= Html::encode($result['end_dt']) ?><?php endif;?> </p>
					<p class="Comiket-title-right-map"><?= Html::encode($result['address']) ?></p>
					<p class="Comiket-title-right-rmb">
						<span class="Comiket-title-right-rmb-one">
							<!--<span class="font-ccc">预售票：</span><span class="fonts-ff">45元</span>-->
						</span>
						<span class="Comiket-title-right-rmb-two">
							<!--<span class="font-ccc">现场票：</span><span class="fonts-ff">60元</span>-->
						</span>
					</p>
				</div>
			</div>
			<div>
				<ul class="cadan">
					<li class="cadan-sel"><span>漫展详细</span></li>
					<li><span>漫展返图</span></li>
					<li class="mamz"><span>漫展购票</span></li>
				</ul>
				<div class="sel-tab">
					<div class="details sel-conter">
						<?= $result['content'] ?>
					</div>
					<div class="backpic sel-conter">
					</div>
					
				</div>
			</div>
		</div>
		<div class="mask swiper-slide" style="display: none;">
			<div class="pay ani"  swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s" swiper-animate-delay="0.3s">
						<div class="pay-bottom">
							<div class="pay-wrap-top">
								<p class="pay-img"><img src="/assets/images/p_03.png" alt="" /></p>
								<p class="pay-rmb"><span>售价：</span><span>45元</span><span>【电子票】</span></p>
								<p class="pay-data"><span>截止购买时间：</span><span>12/25日 20:00</span></p>
								<img src="/assets/images/x_03.png" alt=""  class="close">
							</div>
							<div style="clear: both;"></div>
							<ul class="piao-type">
								<?php foreach($ticket as $row): ?>
									<li end_dt="<?= $row['end_dt'] ?>" number="<?= $row['number'] ?>"><span class="type-title"><?= $row['title'] ?></span><span class="type-rmb"><em>&yen;</em><?= $row['price'] ?><em></em></span></li>
								<?php endforeach; ?>
							</ul>
							<p class="gou-number">
								<span>最多购买<span class="max-number">10</span>张</span>
								<em class="gou-one">
									<span class="gou-add odd"><img src="/assets/images/odd_03.png"/></span>
									<input type="text" value="1" disabled="disabled" class="gou-sl number-pay">
									<span class="gou-min add"><img src="/assets/images/odd_05.png"/></span>
								</em>
							</p>
							<div type="submit" name="" class="sub-ok">确认</div>
						</div>
					</div>
		</div>
	</body>
	<script src="/assets/js/jquery-1.9.1.js"></script>
	<script src="/assets/js/size.js"></script>
	<script>
		var id = '<?= intval(\Yii::$app->request->get('id')) ?>';
		var token = '<?= \YII::$app->request->get('token') ?>';
		var userid = '<?= \YII::$app->request->get('userid') ?>';
		
		$(document).ready(function(){  
		    var p=0,t=0;  
		$(window).scroll(function  () {
			var wh=$(window).scrollTop()//滚动条距顶端的距离
			var ch=$(".cadan").offset().top//菜单距离顶端的距离
			var dh=$(".sel-tab").offset().top//参照物距离顶端的距离
			var d=dh-wh//参照物滚动后距离顶端的距离
			var h=ch-wh//滚动后距离顶端的距离
			var cahe=$(".cadan").height()
			var db=wh-cahe
     		p = $(this).scrollTop();  
			var xxx=d-cahe
           
     		if (h<=0) {
				$(".cadan").addClass("cadan-top")
			}
            if (xxx>0) {
            	
           		$(".cadan").removeClass("cadan-top")	
            }

            setTimeout(function(){t = p;},0);         
		    });  
		}); 
		
	
		
	

	$(window).load(function  () {
		$.get("/circle/circlelist?id="+id+"&page=1&pagesize=3&token="+token+"&userid="+userid+"",function  (data) {
			if(data.code == 200) {
				
				
				console.log(data)
				console.log("aaa")
				var zp='';
			for ( i in data.data) {
				
				var dateStr=data.data[i].create_time
				
				function getDateDiff(){
					var minute = 1000 * 60;
					var hour = minute * 60;
					var day = hour * 24;
					var halfamonth = day * 15;
					var month = day * 30;
					var now = new Date().getTime()
					var ccc=dateStr*1000
					var diffValue = now - ccc;
					if(diffValue < 0){return;}
					var monthC =diffValue/month;
					var weekC =diffValue/(7*day);
					var dayC =diffValue/day;
					var hourC =diffValue/hour;
					var minC =diffValue/minute;
					if(monthC>=1){
						result="" + parseInt(monthC) + "月前";
					}
					else if(weekC>=1){
						result="" + parseInt(weekC) + "周前";
					}
					else if(dayC>=1){
						result=""+ parseInt(dayC) +"天前";
					}
					else if(hourC>=1){
						result=""+ parseInt(hourC) +"小时前";
					}
					else if(minC>=1){
						result=""+ parseInt(minC) +"分钟前";
					}else
					result="刚刚";
					return result;
				}
				var str = getDateDiff(dateStr);
				// 在控制台输出结果 
				console.log(str);
				zp+='<div class="backpic-conter"><div class="backpic-wrap"><div class="backpic-user"><a href=""><img src="'+data.data[i].icon+'" alt="" /></a>';
				zp+='</div><div class="back-data"><p>'+data.data[i].nickname+'</p><p>'+str+'</p></div><div class="back-hack"><a href=""><img src="/assets/images/mis_03.png" alt="" /><span>'+data.data[i].comment_number+'</span>';
				zp+='</a></div></div><div><p class="back-title">'+data.data[i].title+'</p>';
				zp+='<p class="back-title-one">'+data.data[i].content+'</p><a href=""><ul class="back-photo">';
				for (a in data.data[i].images){
						zp+='<li><img src="'+data.data[i].images[a].source+'" alt="" /></li>';
				}
			
				
				zp+='</ul></a></div></div>';
			}
			$(".backpic").append(zp);}
			var y=1
			$(window).scroll(function  () {if (Math.ceil($(window).scrollTop())>= Math.ceil($(document).height()-$(window).height())) {
				y++;
				$.get("/circle/circlelist?id="+id+"&page="+y+"&pagesize=3&token="+token+"&userid="+userid+"",function  (data) {
				//=======================================================================================================================
	
				
				
				//=======================================================================================================================
					})
				}
			})

		})	

	})
	
	$(".back-photo").each(function  () {
			console.log($(this).find("li").length)
			var lis=$(this).find("li").length
			if (lis==1) {
				$(this).attr("class","getsize")
			}
	})
//				
//					
//		
	</script>
</html>
