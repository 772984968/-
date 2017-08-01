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
		<link rel="stylesheet" type="text/css" href="/assets/css/pay-page.css"/>
		<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
	</head>
	<body>
		
		<div class="Comiket-wrap">
			<div class="Comiket-title">
				<div class="Comiket-title-left">
					<img src="<?= Html::encode($result['img_link']) ?>" alt="" />
				</div>
			
				<div class="Comiket-title-right">
					<p class="Comiket-title-right-title"><?= Html::encode($result['title']) ?></p>
					<p class="Comiket-title-right-data"> <?= Html::encode(date('Y年m月d日',strtotime($result['dt']))) ?><?php if(date('Y年m月d日',strtotime($result['end_dt']))):?>&nbsp;—&nbsp;<?= Html::encode(date('Y年m月d日',strtotime($result['end_dt']))) ?><?php endif;?> </p>
					<p class="Comiket-title-right-map"><?= Html::encode($result['address']) ?></p>
					<p class="Comiket-title-right-rmb">
						<span class="Comiket-title-right-rmb-one">
							<span class="font-ccc">预售票：</span><span class="fonts-ff"><?= Html::encode($result['presell_price']) ?>元</span>
						</span>
						<span class="Comiket-title-right-rmb-two">
							<span class="font-ccc">现场票：</span><span class="fonts-ff"><?= Html::encode($result['scene_price']) ?>元</span>
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
								<p class="pay-img"><img src="<?= Html::encode($result['img_link']) ?>" alt="" /></p>
								<p class="pay-rmb"><span>售价：</span><span class="rmbsl">45元</span><span>【电子票】</span></p>
								<p class="pay-data"><span>截止购买时间：</span><span class="jzrq">12/25日 20:00</span></p>
								<img src="/assets/images/x_03.png" alt=""  class="close">
							</div>
							<div style="clear: both;"></div>
							<ul class="piao-type">
								<?php foreach($ticket as $row): ?>
									<li product_id="<?= $row['ticket_id'] ?>" end_dt="<?= date('m/d日 H:s',$row['end_dt']) ?>" number="<?= $row['number'] ?>"><span class="type-title"><?= $row['title'] ?></span><span class="type-rmb">&yen;<em class="rmbpr"><?= $row['money'] ?></em></span></li>
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
		
		<div class="pay-page-wrap" style="display: none;">
			<div class="pay-tit-conter">
				<span><img src="<?= Html::encode($result['img_link']) ?>" alt="" /></span>
				<p class="tit-title">【电子票】<span><?= Html::encode($result['title']) ?></span></p><br />
				<p class="tit-rmb"><span>售价：</span><span class="qs">45</span><span>元</span></p><br />
				<p class="tit-data">截止购买时间：<span class="sssjsj">12/25 20:00</span></p>
			</div>
			<div class="pay-number1">
				<span>最多购买<span class="max-number1">10</span>张</span>
				<p>
					<span class="odd odd1"><img src="/assets/images/odd_03.png" alt="" /></span>
					<input type="text" value="1"  class="number-pay1" max="10" min="1" disabled="disabled">
					<span class="add add1"><img src="/assets/images/odd_05.png"/></span>
				</p>
			</div>
			<div class="map-wrap">
				<p class="map-title">确认地址</p>
				<p class="map-map"><span>漫展地址：</span><span><?= Html::encode($result['address']) ?></span></p>
				<p class="map-data"><span>漫展时间：</span><span></span></p>
			</div>
			<div class="map-wrap">
				<p class="map-title">确认联系人</p>
				<p class="map-ma-new"><span>黄靖翔：</span><span>13585858585</span></p>
			
			</div>
			<ul class="pay-bottom1">
				<li><span>合计：</span><span class="rmb-jg zjj">45</span><span class="rmb-jg">元</span></li>
				<li class="qryy qryyand"><a href="javascript:void(0);">确认预约</a></li>
			</ul>
		</div>

	</body>
	<script src="/assets/js/jquery-1.9.1.js"></script>
	<script src="/assets/js/size.js"></script>
	<script>
		var id = '<?= intval(\Yii::$app->request->get('id')) ?>';
		var token = '<?= \YII::$app->request->get('token') ?>';
		var userid = '<?= \YII::$app->request->get('userid') ?>';
		$(window).load(function  () {
			$('.piao-type li').eq(0).trigger("click");
		})
		$(".piao-type li").click(function  () {
			$(this).css({border:"#ff9933 solid 0.02666rem"}).siblings().css({border:"0.02666rem solid #999999"})
			var num=$(this).attr("number")
			var endtime=$(this).attr("end_dt")
			var rmb_pr=$(this).find(".rmbpr").text()
			$(".rmbsl").html(rmb_pr+"元")
			$(".qs").html(rmb_pr)
			$(".max-number").text(num)
			$(".max-number1").text(num)
			$(".jzrq").html(endtime)
			$(".sssjsj").html(endtime)
			window.idid=$(this).attr("product_id")
			
			console.log(idid)
		})
		$(".sub-ok").on("click",function  () {
			$(".Comiket-wrap").hide()
			$(".mask").hide()
			$(".pay-page-wrap").show(0,function  () {
				var sl=$(".number-pay").val()
				var sj=$(".qs").text()
				$(".zjj").html(sl*sj)
			})
			
			
		})
		$(".add1, .odd1, .add, .odd").click(function  () {
			var sl=$(".number-pay").val()
			$(".number-pay1").val(sl)
			var sj=$(".qs").text()
			$(".zjj").html(sl*sj)
		})
		
		
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
		var ch=$(".Comiket-title").height()
		$(".Comiket-title-left img ").height(ch)
		
		
		$.get("/circle/circlelist?id="+id+"&page=1&pagesize=3&token="+token+"&userid="+userid+"",function  (data) {
			if(data.code == 200) {
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
				if(data.code == 200) {
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
	
	
	
	function setupWebViewJavascriptBridge(callback) {
    if (window.WebViewJavascriptBridge) { return callback(WebViewJavascriptBridge); }
    if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }
    window.WVJBCallbacks = [callback];
    var WVJBIframe = document.createElement('iframe');
    WVJBIframe.style.display = 'none';
    WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
    document.documentElement.appendChild(WVJBIframe);
    setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0)
}
setupWebViewJavascriptBridge(function(bridge) {
	
		
    $(".qryy").click(function(){
    	var sl=$(".number-pay1").val()
        bridge.callHandler('manzhan',{mzid:idid,shul:sl},function  (response) {
        
    	});
     });
     
   
})

			var ua = navigator.userAgent.toLowerCase();
			    if (ua.match(/Android/i) == "android") {
				    $(".qryyand").click(function  () {
				    	var sl=$(".number-pay1").val()
						window.yuhaodong2.startYHD2(idid,sl)
					})
			         
		    }
		
 
	</script>
</html>
