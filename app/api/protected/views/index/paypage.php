<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="/assets/css/pay-page.css"/>
		<link rel="stylesheet" type="text/css" href="/assets/css/normalize.css"/>
		<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
	</head>
	<body>
		<div class="pay-page-wrap">
			<div class="pay-tit-conter">
				<span><img src="/assets/images/t_03.png" alt="" /></span>
				<p class="tit-title">【电子票】2017萤火虫漫展</p><br />
				<p class="tit-rmb"><span>售价：</span><span class="qs">45</span><span>元</span></p><br />
				<p class="tit-data">截止购买时间：<span>12/25 20:00</span></p>
			</div>
			<div class="pay-number">
				<span>最多购买<span class="max-number">10</span>张</span>
				<p>
					<span class="odd"><img src="/assets/images/odd_03.png" alt="" /></span>
					<input type="text" value="1"  class="number-pay" max="10" min="1">
					<span class="add"><img src="/assets/images/odd_05.png"/></span>
				</p>
			</div>
			<div class="map-wrap">
				<p class="map-title">确认地址</p>
				<p class="map-map"><span>漫展地址：</span><span>广州国际采购中心1-3号管首层</span></p>
				<p class="map-data"><span>漫展时间：</span><span>2017-05-01</span></p>
			</div>
			<div class="map-wrap">
				<p class="map-title">确认联系人</p>
				<p class="map-ma-new"><span>黄靖翔：</span><span>13585858585</span></p>
			
			</div>
			<ul class="pay-bottom">
				<li><span>合计：</span><span class="rmb-jg zjj">45</span><span class="rmb-jg">元</span></li>
				<li class="qryy"><a href="">确认预约</a></li>
			</ul>
		</div>
	</body>
	<script src="/assets/js/jquery-1.9.1.js"></script>
	<script src="/assets/js/size.js"></script>
	<script>
		$(".add, .odd").click(function  () {
			var sl=$(".number-pay").val()
			var sj=$(".qs").text()
			$(".zjj").html(sl*sj)
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
    	var labelid=$(this).attr("labelid")
        bridge.callHandler('manzhan',{Id:labelid},function  (response) {
        	
    	});
     });
     
   
})
 
	</script>
</html>
