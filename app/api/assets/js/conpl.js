//精选内容的评论
(function($,undefined){
	$.fn.zyComment = function(options,param){
		var otherArgs = Array.prototype.slice.call(arguments, 1);
		if (typeof options == 'string') {
			var fn = this[0][options];
			if($.isFunction(fn)){
				return fn.apply(this, otherArgs);
			}else{
				throw ("zyComment - No such method: " + options);
			}
		}

		return this.each(function(){
			var para = {};    // 保留参数
			var self = this;  // 保存组件对象
			var fCode = 0;
			
			var defaults = {
					"width":"355",
					"height":"33",
					"agoComment":[],  // 以往评论内容
					"callback":function(comment){
						console.info("返回评论数据");
						console.info(comment);
					}
			};
			
			para = $.extend(defaults,options);
			
			this.init = function(){
				this.createAgoCommentHtml();  // 创建以往评论的html
			};
			
			/**
			 * 功能：创建以往评论的html
			 * 参数: 无
			 * 返回: 无 
			 */
			this.createAgoCommentHtml = function(){
				
				var html = '';
				$(self).append(html);
				$.each(para.agoComment, function(k, v){
					
					var topStyle = "";
					if(k>0){
						topStyle = "topStyle";
					}
					
					var item = '';
					item += '<div class="oun-pl-conter">';
					item += '<div class="conter-wrap">';
					item += '<div class="oun-pl-left"><a href="#"><img src="/assets/images/pic_29.png"/></a></div>';
					item += '<div class="oun-pl-right">';
					item += '<p class="pl-one"><span class="oun-name">'+v.userName+' </span><span class="oun-time">'+v.time+' </span><span class="oun-rep cllll"><a href="#" class="plclick"><img src="/assets/images/mis_03.png"/></a></span></p>';
					item += '<p class="oun-flo">'+v.userName+' </p>';
					item += '<p class="oun-nron">'+v.userName+' </p>';
					item += '</div>';
					item += '<div style="clear: both;"></div>';
					item += '<div class="oun-pl-bottom">';
					item += '<p><span class="oun-font cllll">'+v.userName+'</span><span>转载你个头啊 我自己会转账啊是大家说的；老金；啊、</span></p>';
					item += '<p><span class="oun-font cllll">'+v.userName+'</span><span class="oun-font">'+'&nbsp;回复&nbsp;'+v.userName+':'+'</span><span>'+v.content+'</span></p>';
					item += '<p><span class="oun-font cllll">'+v.userName+'</span><span class="oun-font">'+'&nbsp;回复&nbsp;'+v.userName+':'+'</span><span>'+v.content+'</span></p>';
					item += '</div>';
					item += '<div class="oun-more">';
					item += '<p class="oun-font">更多回复共<span>'+v.userName+' </span>条......</p>';
					item += '</div>';
					item += '</div>';
					
//					console.log(item)
					$("#articleComment").append(item); 
		
					// 判断此条评论是不是子级评论
					
				});

			};
			//页面初始化之后评论的回复少于三条隐藏掉他的显示更多菜单
			$(window).load(function  () {
				$(".oun-pl-wrap").each(function  () {
					if(	$(this).find($(".oun-pl-bottom").length==3)){
						console.log($(this).find(".oun-more"))
						$(this).find(".oun-more").hide()
					}
				})
				//加载完成后循环楼层
				var i=1
				$(".oun-pl-conter").each(function  () {
					$(this).find(".oun-flo").html("第"+i+"楼")
					i++;
				})
			})
				

			

			
			// 初始化上传控制层插件
			this.init();
		});
	};
})(jQuery);

$(document).ready(function() {
	
$(window).scroll(function() {

    if ($(document).scrollTop()<=0){
      $(".fas1-wrap").slideUp()
    }

    if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
    	$(".submit-ll").hide()
     $(".fas1-wrap").slideDown(300,function  () {
     	
     	$(".fas1").focus(function  () {
     		$(".fas1-fs").click(function  () {
     			
     			var t3=$(".fas1").val()
     			if (t3=="") {
     				return;
     			}
     			console.log(t3);
     			var CommentForm = {};
     			CommentForm['object_id'] = 5;
     			CommentForm['content'] = t3;
     			var json = {CommentForm};
				$.post("http://api.er.cc/product/commentadd",json
				,function(data){
					console.log(data)
				function getLocalTime(nS) {     
				    return new Date(parseInt(nS) * 1000).toLocaleString().substr(5,5)
				}     
				var lo=getLocalTime(data.data.create_time).replace("/","-")
					var teee = '';
					teee += '<div class="oun-pl-conter" product_comment_id="'+data.data.product_comment_id+'" user_id="'+data.data.user_id+'">';
					teee += '<div class="conter-wrap">';
					teee += '<div class="oun-pl-left"><a href="#"><img src="'+data.data.icon+'"/></a></div>';
					teee += '<div class="oun-pl-right">';
					teee += '<p class="pl-one"><span class="oun-name">'+data.data.nickname+'</span><span class="oun-time">'+lo+'</span><span class="oun-rep cllll"><a href="javascript:void(0);" class="plclick"><img src="/assets/images/mis_03.png"/></a></span></p>';
					teee += '<p class="oun-flo"></p>';
					teee += '<p class="oun-nron">'+data.data.content+' </p>';
					teee += '</div>';
					teee += '<div style="clear: both;"></div>';
					teee += '<div class="oun-pl-bottom">';
					teee += '</div>';
					teee += '<div class="oun-more">';
					teee += '</div>';
					teee += '</div>';
				$(".oun-pl-wrap").append(teee);//新的评论内容插入到最后
				var lo=$(".oun-pl-wrap").find(".oun-pl-conter").last().prevObject.length //获取刚加入的评论的楼层数
				$(".oun-pl-wrap").find(".oun-pl-conter").last().find(".oun-flo").html("第"+lo+"楼")
				$(".fas1-wrap").slideUp(300)//收起评论框
				
				})
				
     			$(".fly").val("")//清空输入框
     			})
     		})
    	 })
    	}
	});
});
				var _this = "";
				$("body").on("click",".oun-rep",function(){
					$(".submit-ll").hide()
					$(".fas2-wrap").slideDown(300)
					
					_this=$(this);
					console.log($(this).parents(".oun-pl-right").find(".oun-nron").text());
					
				});		
				$(".fas2-fs").on("click",function  () {
						
						var con=$(".fas2").val();
						if ($(".fas2").val()=="") {
							return;
						}
						var lll=$(_this).parents(".oun-pl-conter").attr("user_id")
						var CommentForm = {};
		     			CommentForm['object_id'] = 8;
		     			CommentForm['content'] = con;
		     			CommentForm['comment_id']=lll
		     			var json = {CommentForm};
						$.post("http://api.er.cc/product/commentaddson",json
						,function(data){
							console.log(data)
							var iteee=""
							iteee += '<p><span class="oun-font cllll" product_comment2_id="'+data.data.product_comment2_id+'" comment_id="'+data.data.comment_id+'" user_id="'+data.data.user_id+'" receiver_id="'+data.data.receiver_id+'">'+data.data.nickname+'</span><span>：'+data.data.content+'</span></p>';
							_this.parents(".oun-pl-conter").find(".oun-pl-bottom").append(iteee)
							$(".fas2-wrap").slideUp(300)
						})
						$(".fas2").val("")
					})
				$("body").on("click",".oun-font",function  () {
						//回复一级评论
					
					_this=$(this)
					$(".submit-ll").hide()
					$(".fas3-wrap").slideDown(300)
				
//					$(".submit-ll-fs").off("click")
				});	
				$(".fas3-fs").on("click",function  () {
						var con=$(".fas3").val();
						if ($(".fas3").val()=="") {
							return;
						}
						var lll=$(_this).attr("product_comment2_id")
						var bbb=$(_this).attr("user_id")
						console.log(bbb)
						var CommentForm = {};
		     			CommentForm['object_id'] = 8;//
		     			CommentForm['content'] = con; //评论的内容
		     			CommentForm['comment_id']=lll;//评论的id
		     			CommentForm['receiver_id']=bbb;//怼人的id
		     			var json = {CommentForm};
						$.post("http://api.er.cc/product/commentaddson",json
						,function(data){
						console.log(data)
						var text=$(_this).text()
						var iteee=""
						iteee += '<p><span class="oun-font cllll" product_comment2_id="'+data.data.product_comment2_id+'"  receiver_id="'+data.data.receiver+'" comment_id="'+data.data.comment_id+'" user_id="'+data.data.user_id+'">'+data.data.nickname+'</span><span class="oun-font2">&nbsp;回复&nbsp;'+data.data.nickname+':</span><span>'+data.data.content+'</span></p>';
						$(_this).parents(".oun-pl-bottom").append(iteee)
						
						$(".fas3-wrap").slideUp(300)
					})
					$(".fas3").val("")
})