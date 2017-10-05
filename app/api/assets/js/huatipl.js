
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
					item += '<div class="oun-pl-left"><a href="/assets/"><img src="/assets/images/pic_29.png"/></a></div>';
					item += '<div class="oun-pl-right">';
					item += '<p class="pl-one"><span class="oun-name">'+v.userName+' </span><span class="oun-time">'+v.time+' </span><span class="oun-rep cllll"><a href="/assets/" class="plclick"><img src="/assets/images/mis_03.png"/></a></span></p>';
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
					if(v.sortID==0){  // 不是
						$("#commentItems").append(item);
					}else{  // 否
						// 判断父级评论下是不是已经有了子级评论
						if($("#comment"+v.sortID).find(".comments").length==0){  // 没有
							var comments = '';
							comments += '<div id="comments'+v.sortID+'" class="comments">';
							comments += 	item;
							comments += '</div>';
							
							$("#comment"+v.sortID).append(comments);
						}else{  // 有
							$("#comments"+v.sortID).append(item);
						}
					}
				});
				this.createFormCommentHtml();  // 创建发表评论的html
				console.log("1")
			};
			//页面初始化之后评论的回复少于三条隐藏掉他的显示更多菜单
			$(window).load(function  () {
				$(".oun-pl-wrap").each(function  () {
					if(	$(this).find($(".oun-pl-bottom").length==3)){
						console.log($(this).find(".oun-more"))
						$(this).find(".oun-more").hide()
					}
				})
			})
				

			/**
			 * 功能：创建评论form的html
			 * 参数: 无
			 * 返回: 无 
			 */
			this.createFormCommentHtml = function(){
				// 先添加父容器
				$(self).append('<div id="commentFrom"></div>');
				
				// 组织发表评论的form html代码
				
	            // 初始化html之后绑定点击事件
	            
				};
				
			
			
			/**
			 * 功能：绑定事件
			 * 参数: 无
			 * 返回: 无
			 */
			
			/**
			 * 功能: 绑定item上的回复事件
			 * 参数: 无
			 * 返回: 无
			 */
			
			/**
			 * 功能: 绑定item上的取消回复事件
			 * 参数: 无
			 * 返回: 无
			 */
			
			/**
			 * 功能: 绑定回复框的事件
			 * 参数: 无
			 * 返回: 无
			 */
		
	
			
			// 移除所有回复框
		
			
			// 添加回复下的回复框
			
			
			// 添加根下的回复框
		
			
			// 得到回复的评论的id
		
			
			// 设置评论成功之后的内容
		
			
			// 添加新评论的内容
			this.addNewComment = function(param){
				var topStyle = "";
				if(parseInt(fCode)!=0){
					topStyle = "topStyle";
				}
				
				

//				if(parseInt(fCode)==0){  // 如果对根添加
//					$("#commentItems").append(item);
//				}else{
//					// 判断父级评论下是不是已经有了子级评论
//					if($("#comment"+fCode).find(".comments").length==0){  // 没有
//						var comments = '';
//						comments += '<div id="comments'+fCode+'" class="comments">';
//						comments += 	item;
//						comments += '</div>';
//						
//						$("#comment"+fCode).append(comments);
//					}else{  // 有
//						$("#comments"+fCode).append(item);
//					}
//				}
			};
			
			
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
     			var CommentForm = {};
     			CommentForm['object_id'] = 5;
     			CommentForm['content'] = t3;
     			var json = {CommentForm};
				$.post("http://api.er.cc/product/commentadd",json
				,function(data){
					console.log(data);
				})
     		
     			var teee = '';
					teee += '<div class="oun-pl-conter">';
					teee += '<div class="conter-wrap">';
					teee += '<div class="oun-pl-left"><a href="/assets/"><img src="/assets/images/pic_29.png"/></a></div>';
					teee += '<div class="oun-pl-right">';
					teee += '<p class="pl-one"><span class="oun-name">ggg </span><span class="oun-time">s</span><span class="oun-rep cllll"><a href="/assets/" class="plclick"><img src="/assets/images/mis_03.png"/></a></span></p>';
					teee += '<p class="oun-flo">sssss </p>';
					teee += '<p class="oun-nron">'+t3+' </p>';
					teee += '</div>';
					teee += '<div style="clear: both;"></div>';
					teee += '<div class="oun-pl-bottom">';
					teee += '</div>';
					teee += '<div class="oun-more">';
					teee += '</div>';
					teee += '</div>';
				$(".oun-pl-wrap").append(teee)
				$(".fly").val("")
				$(".fas1-wrap").slideUp(300)
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
						var iteee=""
						console.log(_this.parents(".oun-pl-right").find(".oun-nron").text());
						iteee += '<p><span class="oun-font cllll">于号东666</span><span>：'+con+'</span></p>';
						_this.parents(".oun-pl-conter").find(".oun-pl-bottom").append(iteee)
						$(".fas2").val("")
						
						$(".fas2-wrap").slideUp(300)
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
						var text=$(_this).text()
						var iteee=""
						iteee += '<p><span class="oun-font cllll">于号东2</span><span class="oun-font2">&nbsp;回复&nbsp;'+text+':</span><span>'+con+'</span></p>';
						$(_this).parents(".oun-pl-bottom").append(iteee)
						$(".fas3").val("")
						$(".fas3-wrap").slideUp(300)
					})

