 //


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
					"agoComment":[]  // 以往评论内容
					
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
					//加载完成后循环楼层
					var i=1
					$(".oun-pl-conter").each(function  () {
						$(this).find(".oun-flo").html("第"+i+"楼")
						i++;
					})
					console.log(v)
					function getLocalTime(nS) {     
					    return new Date(parseInt(nS) * 1000).toLocaleString().substr(5,4)
					}     
					var lo=getLocalTime(v.create_time).replace("/","-")
					var item = '';
					item += '<div class="oun-pl-conter" comment_id="'+v.comment_id+'" target_id="'+v.target_id+'" >';
					
					item += '<div class="conter-wrap">';
					item += '<div class="oun-pl-left"><a href=""><img src="'+v.icon+'"/></a></div>';
					item += '<div class="oun-pl-right">';
					item += '<p class="pl-one"><span class="oun-name">'+v.nickname+' </span><span class="oun-time">'+lo+' </span><span class="oun-rep cllll"><a href="javascript:void(0);" class="plclick"><img src="/assets/images/mis_03.png"/></a></span></p>';
					item += '<p class="oun-flo"></p>';
					item += '<p class="oun-nron">'+v.content+' </p>';
					item += '</div>';
					item += '<div style="clear: both;"></div>';
					item += '<div class="oun-pl-bottom">';
					
					for (var i in v.son)
						{
							if (v.son[i].receiver=="") {
								item += '<p><span class="oun-font cllll" comment2_id="'+v.son[i].comment_id+'"  comment_id="'+v.son[i].comment2_id+'" user_id="'+v.son[i].user_id+'" target_id="'+v.son[i].target_id+'">'+v.son[i].nickname+':</span><span>&nbsp;'+v.son[i].content+'</span></p>';
	
							}
							else{
								item += '<p><span class="oun-font cllll" comment2_id="'+v.son[i].comment_id+'"  comment_id="'+v.son[i].comment2_id+'" user_id="'+v.son[i].user_id+'" target_id="'+v.son[i].target_id+'">'+v.son[i].receiver+'</span><span class="oun-font">'+'&nbsp;回复&nbsp;'+v.son[i].nickname+':'+'</span><span>'+v.son[i].content+'</span></p>';
	
							}
						}
					item += '</div>';
					item += '<div class="oun-more">';
					item += '<p class="oun-font">更多回复共<span></span>条......</p>';
					item += '</div>';
					item += '</div>';
					$("#articleComment").append(item); 
					//获取子评论的个数
					$(".oun-pl-bottom").each(function  () {
						var v=$(this).find("p").length
						$(this).parents(".oun-pl-conter").find(".oun-font span").text(v)
						if (v==0) {
							$(this).css({border:0})
						}
						if (v<=3) {
							$(this).parents(".oun-pl-conter").find(".oun-more").remove()
							//子评论的个数小于等于3去掉显示更多选项
						}
						else{
							$(this).parents(".oun-pl-conter").find(".oun-pl-bottom p:gt(2)").hide()
							//子评论大于3条的时候加上显示更多
						}
					})
					$("body").on("click",".oun-more .oun-font",function  () {
						$(this).parents(".oun-pl-conter").find(".oun-pl-bottom p:gt(2)").show(800)
					})
					//修改楼层数
					var i=1
					$(".oun-pl-conter").each(function  () {
						$(this).find(".oun-flo").html("第"+i+"楼")
						i++;
					})
					//评论的回复少于三条隐藏掉他的显示更多菜单
					
				});

			};
				
				
			// 初始化上传控制层插件
			this.init();
		});
	};
})(jQuery);


//=============================================滚动条上滚消失input框 同时不能评论==================================================
		function sild () {
				$(".fas1-wrap").show(300,function  () {
		     	$(".fas1").focus(function  () {
		     		$(".fas1-fs").click(function  () {
		     			
		     			var t3=$(".fas1").val()
		     			if (t3=="") {
		     				return;
		     			}
		     			console.log(t3);
		     			var CommentForm = {};
		     			CommentForm['object_id'] = id;
		     			CommentForm['content'] = t3;
		     			var json = {CommentForm};
						$.post("/circle/commentadd?token="+token+"&userid="+userid+"",json
						,function(data){
							console.log(data)
						function getLocalTime(nS) {     
						    return new Date(parseInt(nS) * 1000).toLocaleString().substr(5,4)
						}     
						var lo=getLocalTime(data.data.create_time).replace("/","-")
							var teee = '';
							teee += '<div class="oun-pl-conter" comment_id="'+data.data.comment_id+'" user_id="'+data.data.user_id+'">';
							teee += '<div class="conter-wrap">';
							teee += '<div class="oun-pl-left"><a href=""><img src="'+data.data.icon+'"/></a></div>';
							teee += '<div class="oun-pl-right">';
							teee += '<p class="pl-one"><span class="oun-name">'+data.data.nickname+'</span><span class="oun-time">'+lo+'</span><span class="oun-rep cllll"><a href="" class="plclick"><img src="/assets/images/mis_03.png"/></a></span></p>';
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
						$(".oun-pl-wrap").css({background:"#fff"})
							var lo=$(".oun-pl-wrap").find(".oun-pl-conter").last().prevObject.length //获取刚加入的评论的楼层数
							$(".oun-pl-wrap").find(".oun-pl-conter").last().find(".oun-flo").html("第"+lo+"楼")
//							$(".fas1-wrap").hide(300)//收起评论框
							})
			     			$(".fly").val("")//清空输入框
		     			})
		     		})
		     	});

				}





//=============================================滚动条上滚消失input框 同时不能评论==================================================


//=============================================直接发表评论的==================================================

//$(document).ready(function() {
//	$(window).scroll(function() {
//
//  if ($(document).scrollTop()<=0){
//    $(".fas1-wrap").hide()
//  }
//  if (Math.ceil($(document).scrollTop()) >= Math.ceil($(document).height() - $(window).height())) {
//  $(".submit-ll").hide()
    sild ()
//  	}
//	});
//});
//	var beforeScrollTop =$('.select-wrap').scrollTop();
//	$('.select-wrap').on('scroll',function(){
//		var afterScrollTop = $('.select-wrap').scrollTop();
//		            delta = afterScrollTop - beforeScrollTop;
//		        if( delta === 0 ) return false;
//		        if (delta > 0) {
//					sild ()	
//		        } else{
// 					$(".fas1-wrap").hide()
//		        }
//		        beforeScrollTop = afterScrollTop;
//	});

//=============================================直接发表评论的==================================================


//=============================================点击评论图标==================================================
				var _this = "";
				$("body").on("click",".oun-rep",function(){
					$(".submit-ll").hide()
					$(".fas2-wrap").show(300)
					
					_this=$(this);
					console.log($(this).parents(".oun-pl-conter").attr("comment_id"));
					
				});		
				$(".fas2-fs").on("click",function  () {
						
						var con=$(".fas2").val();
						if ($(".fas2").val()=="") {
							return;
						}
						var lll=$(_this).parents(".oun-pl-conter").attr("comment_id")
						console.log(lll)
						var CommentForm = {};
		     			CommentForm['object_id'] = id;
		     			CommentForm['content'] = con;
		     			CommentForm['comment_id']=lll
		     			var json = {CommentForm};
						$.post("/circle/commentaddson?token="+token+"&userid="+userid+"",json
						,function(data){
							console.log(data)
							var iteee=""
							iteee += '<p><span class="oun-font cllll" comment_id="'+lll+'" comment2_id="'+data.data.comment2_id+'" user_id="'+data.data.user_id+'" receiver_id="'+data.data.receiver_id+'">'+data.data.nickname+'：</span><span>'+data.data.content+'</span></p>';
							_this.parents(".oun-pl-conter").find(".oun-pl-bottom").append(iteee)
							$(".fas2-wrap").hide(300)
							$(".fas1-wrap").show(300)
						})
						$(".fas2").val("")
					})
				
//=============================================点击评论图标==================================================



//=============================================点击人名发表互怼==================================================

				$("body").on("click",".oun-font",function  () {
					//回复一级评论
					
					_this=$(this)
					$(".submit-ll").hide()
					$(".fas3-wrap").show(300)
				

				});	
				$(".fas3-fs").on("click",function  () {
						var con=$(".fas3").val();
						if ($(".fas3").val()=="") {
							return;
						}
						var lll=$(_this).attr("comment2_id")
						var ccc=$(_this).attr("user_id")
						var CommentForm = {};
		     			CommentForm['object_id'] = id;//
		     			CommentForm['content'] = con; //评论的内容
		     			CommentForm['comment_id']=lll;//评论的id
		     			CommentForm['receiver_id']=ccc;//怼人的id
		     			var json = {CommentForm};
						$.post("/circle/commentaddson?token="+token+"&userid="+userid+"",json
						,function(data){
						var text=$(_this).text()
						var iteee=""
						iteee += '<p><span class="oun-font cllll" comment2_id="'+lll+'"  receiver_id="'+data.data.receiver_id+'" comment_id="'+data.data.comment_id+'" user_id="'+data.data.user_id+'">'+data.data.nickname+'</span><span class="oun-font2">&nbsp;回复&nbsp;'+data.data.nickname+':</span><span>'+data.data.content+'</span></p>';
						$(_this).parents(".oun-pl-bottom").append(iteee)
						$(".fas3-wrap").hide(300)
						$(".fas1-wrap").show(300)
					})
					$(".fas3").val("")
 })
				
//=============================================点击人名发表互怼==================================================
