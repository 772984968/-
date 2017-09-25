
function setFont() {
		var HTML=document.getElementsByTagName('html')[0];
		/*var dpr=1;//像素比
		var Size=document.documentElement.clientWidth*dpr/10;*/
		//把viewport视口分成10份的rem,html的font-size为1rem
		var Size=document.documentElement.clientWidth/10;
		if(Size>=75){
			Size=75
		}
		HTML.style.fontSize=Size+'px';
		$("body").css("margin","0 auto")
		$(".oun-pl-wrap").css("margin","0 auto")
		console.log(Size)
	};
	setFont();//初始适配
	window.onresize=function () {//窗口大小改变适配
		setFont();
	};

	$(".add").click(function(){var d=parseInt($(".number-pay").val());var d=d+parseInt(1);var c=parseInt($(".max-number").text());if(d>=c){d=c}if(d<=1){d=1}if(d>1){$(".odd img").attr("src","/assets/images/odd_07.png")}if(d<=1){$(".odd img").attr("src","/assets/images/odd_03.png")}$(".number-pay").val(d)});$(".odd").click(function(){var d=parseInt($(".number-pay").val());var d=d-parseInt(1);var c=parseInt($(".max-number").text());if(d>=c){d=c}if(d<=1){d=1}if(d>1){$(".odd img").attr("src","/assets/images/odd_07.png")}if(d<=1){$(".odd img").attr("src","/assets/images/odd_03.png")}$(".number-pay").val(d)});

	$(".back-photo").each(function  () {
			console.log($(this).find("li").length)
			var lis=$(this).find("li").length
			if (lis==1) {
				$(this).attr("class","getsize")
			}
		})
			
		$(".cadan li").click(function  () {
			$(this).addClass("cadan-sel").siblings().removeClass("cadan-sel")
			console.log($(this).index())
			var i=$(this).index()
			$('.sel-tab .sel-conter').eq(i).show().siblings().hide();
		})	
		$(".mamz").click(function  () {
			$(".sel-conter").hide()
			$(".mask").fadeIn(20,function  () {
//				$(".pay").show()
				$("body").attr("overflow","hidden")
				var a=$(".pay").height()
				console.log(a)
				$(".pay").show()	
			})
		})
		$(".close").click(function  () {
			$(".pay").hide()
			$(".mask").hide()
			$("body").attr("overflow","auto")
		})
		
		
	