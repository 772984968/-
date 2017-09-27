
function setFont() {
		var HTML=document.getElementsByTagName('html')[0];
		/*var dpr=1;//像素比
		var Size=document.documentElement.clientWidth*dpr/10;*/
		//把viewport视口分成10份的rem,html的font-size为1rem
		var Size=document.documentElement.clientWidth/10;
		HTML.style.fontSize=Size+'px';
		
	};
	setFont();//初始适配
	window.onresize=function () {//窗口大小改变适配
		setFont();
	};
	
		

	
	$(".add").click(function(){var d=parseInt($(".number-pay").val());var d=d+parseInt(1);var c=parseInt($(".max-number").text());if(d>=c){d=c}if(d<=1){d=1}if(d>1){$(".odd img").attr("src","/assets/images/odd_07.png")}if(d<=1){$(".odd img").attr("src","/assets/images/odd_03.png")}$(".number-pay").val(d)});$(".odd").click(function(){var d=parseInt($(".number-pay").val());var d=d-parseInt(1);var c=parseInt($(".max-number").text());if(d>=c){d=c}if(d<=1){d=1}if(d>1){$(".odd img").attr("src","/assets/images/odd_07.png")}if(d<=1){$(".odd img").attr("src","/assets/images/odd_03.png")}$(".number-pay").val(d)});
	$(".add1").click(function(){var d=parseInt($(".number-pay1").val());var d=d+parseInt(1);var c=parseInt($(".max-number1").text());if(d>=c){d=c}if(d<=1){d=1}if(d>1){$(".odd1 img").attr("src","/assets/images/odd_07.png")}if(d<=1){$(".odd1 img").attr("src","/assets/images/odd_03.png")}$(".number-pay1").val(d)});$(".odd1").click(function(){var d=parseInt($(".number-pay1").val());var d=d-parseInt(1);var c=parseInt($(".max-number1").text());if(d>=c){d=c}if(d<=1){d=1}if(d>1){$(".odd1 img").attr("src","/assets/images/odd_07.png")}if(d<=1){$(".odd1 img").attr("src","/assets/images/odd_03.png")}$(".number-pay1").val(d)});

	
			
		$(".cadan li").click(function  () {
			$(this).addClass("cadan-sel").siblings().removeClass("cadan-sel")
			console.log($(this).index())
			var i=$(this).index()
			$('.sel-tab .sel-conter').eq(i).show().siblings().hide();
		})	
		$(".mamz").click(function  () {
			if ($(".piao-type li").length==0) {
				$(".rmbsl").html("")
				$(".jzrq").html("")
				$(".max-number").text("0")
				$(".gou-one").hide()
				$(".sub-ok").css({background:"#bababa"})
				$(".sub-ok").off("click")
		}
			$(".sel-conter").hide()
			$(".mask").fadeIn(20,function  () {
//				$(".pay").show()
				$("body").attr("overflow","hidden")
				var a=$(".pay").height()
				$(".pay").show()	
			})
		})
		$(".close").click(function  () {
			$(".pay").hide()
			$(".mask").hide()
			$("body").attr("overflow","auto")
		})
		
		$(".down-app, .down-open").click(function  () {
			window.location.href="http://api.ciyuanjie.cc/index/downpage"
			
		})
		