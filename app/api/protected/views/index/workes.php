<?php
	use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		
		<link rel="stylesheet" type="text/css" href="/assets/css/normalize.css"/>
		<link rel="stylesheet" type="text/css" href="/assets/css/workes.css"/>
		<link rel="stylesheet" type="text/css" href="/assets/css/default-skin/default-skin.css"/>
		<link rel="stylesheet" type="text/css" href="/assets/css/photoswipe.css"/>
		<link rel="stylesheet" href="/assets/css/oun-pl.css" />
		<link rel="stylesheet" href="/assets/css/select-conter.css" />
		<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
	</head>
	<body>
	
	<div class="select-wrap">
			<div class="workes-wrap">
				<p class="worke-title"><?= Html::encode($info['title']) ?></p>
				<p class="mtop"><span class="span-oun">原作</span><span class="yellow"><?= Html::encode($info['source']) ?></span></p>
					<?php foreach($info['coser'] as $k => $coser): ?>
						<p class="mtop"><span class="span-oun"><?php if($k==0):?>角色<?php endif;?></span>
							<span class="worke-name"><?= Html::encode($coser->name) ?></span>
							<span class="worke-name">Cn:<?= Html::encode($coser->cn) ?></span>
						</p>
					<?php endforeach; ?>
				<p class="mtop" style="overflow: hidden;"><span class="span-oun">标签</span>
					
						<span style="width: 8.35rem;display: inline-block; float: right;">
							<?php foreach($info['labels'] as $label): ?>
						<span class="bor-rad ios-rad" labelid="<?= Html::encode($label['label_id']) ?>"><?= Html::encode($label['name']) ?></span>
						
					<?php endforeach; ?>	
						</span>
					
				</p>
				<p class="work-conter"><?= Html::encode($info['content']) ?></p>
			</div>

			<div class="mui-content-padded" data-pswp-uid="1">	
						<?php foreach($info['images'] as $image): ?>
						<figure>
							<span>
							  <a href="<?= Html::encode($image->source) ?>" data-size="0x0">
							  <img  src="<?= Html::encode($image->source) ?>" style="width: 10rem;">
							  </a>
							</span>
						</figure>
						<?php endforeach; ?>		
			</div>
			<p class="qxx">作品权限</p>
			<div class="worker-bottom">
				
				<p>禁止未授权商业性使用 （默认）</p>
				<?php if(!$info['unauthorized_transmit']):?><p>禁止未授权转载</p><?php endif; ?>
				<?php if(!$info['unauthorized_modify']):?><p>禁止未授权修改</p><?php endif; ?>
			</div>
			<div class="backpic-conter">
				<?php foreach($info['status'] as $status): ?>
					
					<div class="sf_id">
					<div class="backpic-wrap" status_id="<?= $status['status_id'] ?>">
						<div class="backpic-user">
							<a href="/assets/"><img src="<?php if($info['userinfo']['icon']): ?><?= Html::encode($info['userinfo']['icon']) ?><?php else: ?> <?php endif;?>" alt=""></a>
						</div>
						<div class="back-data">
							<p><?= Html::encode($info['userinfo']['nickname']) ?></p>
							<p><?= Html::encode(\Yii::$app->params['status'][$status['status']]) ?></p>
						</div>
						<div class="back-hack">
							<a href="/assets/">
								<span><?php if($status['money']): ?>&yen;<?= Html::encode($status['money']) ?><?php else: ?>议价<?php endif;?></span>
							</a>
						</div>
					</div>
					<div>
						<a href="">
							<ul class="back-photo">
								<?php foreach($status['images'] as $image): ?>
									<li><img src="<?= Html::encode($image->thumb) ?>" alt=""></li>
								<?php endforeach; ?>
							</ul>
						</a>
						<p class="back-title"><?= Html::encode($status['content']) ?></p>
					</div>
					<div class="biaoq">
					<span class="biao-map"><?= Html::encode($status['city']) ?></span>
					<span class="biao-time">预约</span>
					<a href=""><span class="biao-yl"><?= Html::encode($status['comment_number']) ?></span></a>
				</div>
				</div>
				<?php endforeach; ?>
				<ul class="work-tab">
					<li class="wo-pl sel-bor"><span>评论(<?= Html::encode($info['comment_number']) ?>)</span></li>
					<li class="wo-dz"><span>点赞(<em class="dzzz"><?= Html::encode($info['praise_number']) ?></em>)</span></li>
				</ul>
				<div class="oun-pl-wrap dz-tab" id="articleComment">
			</div>
			<ul class="dzan dz-tab" style="display: none;">
				
			</ul>
				</div>
			</div>
			
	</div>
		


        <div class="submit-ll fas1-wrap" style="display: none;">
        <input type="text" class="fly fas1" placeholder="请开始你的表演">
        <p class="submit-ll-fs fas1-fs">发送</p>
        </div>

        <div class="submit-ll fas2-wrap" style="display: none;">
        <input type="text" class="fly fas2" placeholder="请开始你的表演">
        <p class="submit-ll-fs fas2-fs">发送</p>
        </div>

        <div class="submit-ll fas3-wrap" style="display: none;">
        <input type="text" class="fly fas3" placeholder="请开始你的表演">
        <p class="submit-ll-fs fas3-fs">发送</p>
        </div>

	
    

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe. 
         It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. 
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <!--<button class="pswp__button pswp__button--share" title="Share"></button>-->

                <!--<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>-->

                <!--<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>-->

                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>
	<div class="scpl-wrap" style="display: none;">
		<p class="y-title">确定删除这条评论？</p>
		<p class="y-qr">确定</p>
		<p class="y-qx">取消</p>
	</div>
	</body>
	<!--<script type="text/javascript" src="/assets/js/jquery-1.9.1.js"></script>-->
	<script src="/assets/js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="/assets/js/mui.min.js"></script>
	<script src="/assets/js/size.js" type="text/javascript"></script>
	<script src="/assets/js/photoswipe-ui-default.min.js" type="text/javascript"></script>
	<script src="/assets/js/photoswipe.js" type="text/javascript"></script>
	<script src="/assets/js/zyComment.js?v20170512" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
	var initPhotoSwipeFromDOM = function(gallerySelector) {

    // 解析来自DOM元素幻灯片数据（URL，标题，大小...）
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
        var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item,
			divEl;

        for(var i = 0; i < numNodes; i++) {

            figureEl = thumbElements[i]; // <figure> element

            // 仅包括元素节点
            if(figureEl.nodeType !== 1) {
                continue;
            }
			divEl = figureEl.children[0];
            linkEl = divEl.children[0]; // <a> element
			
            size = linkEl.getAttribute('data-size').split('x');

            // 创建幻灯片对象
            item = {
                src: linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };



            if(figureEl.children.length > 1) {
                // <figcaption> content
                item.title = figureEl.children[1].innerHTML; 
            }

            if(linkEl.children.length > 0) {
                // <img> 缩略图节点, 检索缩略图网址
                item.msrc = linkEl.children[0].getAttribute('src');
            } 

            item.el = figureEl; // 保存链接元素 for getThumbBoundsFn
            items.push(item);
        }

        return items;
    };

    // 查找最近的父节点
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };

    // 当用户点击缩略图触发
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        var eTarget = e.target || e.srcElement;

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
        });

        if(!clickedListItem) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) { 
                continue; 
            }

            if(childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }



        if(index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
        params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');  
            if(pair.length < 2) {
                continue;
            }           
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);

        // 这里可以定义参数
        options = {
          barsSize: { 
            top: 100,
            bottom: 100
          }, 
		   fullscreenEl : false,
			shareButtons: [
			{id:'wechat', label:'分享微信', url:'#'},
			{id:'weibo', label:'新浪微博', url:'#'},
			{id:'download', label:'保存图片', url:'{{raw_image_url}}', download:true}
			],

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),

            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect(); 

                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }

        };

        // PhotoSwipe opened from URL
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        // exit if index not found
        if( isNaN(options.index) ) {
            return;
        }

        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll( gallerySelector );

    for(var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i+1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if(hashData.pid && hashData.gid) {
        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
    }
	};

	// execute above function
	initPhotoSwipeFromDOM('.mui-content-padded');

	
	$(".mui-content-padded figure span a").each(function(index) {
    var _this = $(this);
    if (_this.attr('data-size') == "0x0") {
      $("<img/>") // Make in memory copy of image to avoid css issues
        .attr("src", _this.attr("href"))
        .load(function() {
          _this.attr('data-size', this.width + "x" + this.height);
        });
    }
  });
	
</script>

	<script>
		
		//===============延时下载==================//
	

	


	
		
	
		
		
		//===============延时下载==================//
		
		
	    var id = '<?= intval(\Yii::$app->request->get('id')) ?>';
		var token = '<?= \YII::$app->request->get('token') ?>';
		var userid = '<?= \YII::$app->request->get('userid') ?>';
		
		$(".work-tab li").click(function  () {
			$(this).addClass("sel-bor").siblings().removeClass("sel-bor")
			var i=$(this).index()
			$('.dz-tab').eq(i).show().siblings(".dz-tab").hide();
		})
		$(".wo-dz").click(function  () {
			$(".submit-ll").hide()
			var ProductForm = {};
 			ProductForm['id'] = id;
 			var json = {ProductForm};
			$.post("/product/praise?token="+token+"&userid="+userid+"",json
			,function(data){
				
				if (data.data.state==0) {
					$(".dzan").html("")
					var a=$(".dzzz").text()
					a=parseInt(a)-1
					$(".dzzz").text(a)
					
				}
				if (data.data.state==1) {
					$(".dzan").html("")
					var a=$(".dzzz").text()
					a=parseInt(a)+1
					$(".dzzz").text(a)
				}
				
				$.get("/product/praiselist?id="+id+"&page=1&token="+token+"&userid="+userid+"",function  (data) {

				if (data.code==200) {
	
						for (var i in data.data)
					{
						var aaa=""
						aaa+='<li><img src="'+data.data[i].icon+'" alt="" userId="'+data.data[i].userId+'"></li>'
						$(".dzan").append(aaa)
					}
				
				}
				
					

					var b=1
		$(".select-wrap").scroll(function  () {
				if (Math.ceil($(".select-wrap").scrollTop())>= Math.ceil($(".select-wrap").height()-$(".select-wrap").height())) {
					b++;
						$.get("/product/praiselist?id="+id+"&page="+b+"&token="+token+"&userid="+userid+"",function  (data) {
						
						if (data.code==200) {
							$(".dzan").html()
							for (var i in data.data)
						{
							var aaa=""
							aaa+='<li><img src="'+data.data[i].icon+'" alt="" /></li>'
							$(".dzan").append(aaa)
						}
						
						}
						
		//					
					})

				}
			})
		})

				
			})
		})
		$(".wo-pl").click(function  () {
			$(".fas1-wrap").show()
		})
		
		//======================<获取点赞列表的>=========================
//$.get("/product/praiselist?id="+id+"&page=1&token="+token+"&userid="+userid+"",function  (data) {
//$(".dzan").html()
//				if (data.code==200) {
//	
//						for (var i in data.data)
//					{
//						var aaa=""
//						aaa+='<li><img src="'+data.data[i].icon+'" alt="" userId="'+data.data[i].userId+'"></li>'
//						$(".dzan").append(aaa)
//					}
//				
//				}
//				
//					
//
//					var b=1
//		$(".select-wrap").scroll(function  () {
//				if (Math.ceil($(".select-wrap").scrollTop())>= Math.ceil($(".select-wrap").height()-$(".select-wrap").height())) {
//					b++;
//						$.get("/product/praiselist?id="+id+"&page="+b+"&token="+token+"&userid="+userid+"",function  (data) {
//						
//						if (data.code==200) {
//							$(".dzan").html()
//							for (var i in data.data)
//						{
//							var aaa=""
//							aaa+='<li><img src="'+data.data[i].icon+'" alt="" /></li>'
//							$(".dzan").append(aaa)
//						}
//						
//						}
//						
//		//					
//					})
//
//				}
//			})
//		})
		//===============================================
		
		
		
		
		
		$.get("/product/commentlist?id="+id+"&page=1&pagesize=3&token="+token+"&userid="+userid+"",function  (data) {
			console.log(data)
			if (data.code==200) {
				$(".oun-pl-wrap").css({background:"#fff"})
				var agoComment=data.data
				$("#articleComment").zyComment({
					"agoComment":agoComment
				});
			}
			
		})
		
		var y=1
		$(".select-wrap").scroll(function  () {
			if (Math.ceil($(".select-wrap").scrollTop())>= Math.ceil($(".select-wrap").height()-$(".select-wrap").height())) {
				y++;

				$.get("/product/commentlist?id="+id+"&page="+y+"&pagesize=3&token="+token+"&userid="+userid+"",function  (data) {
					if (data.code==200) {
						var agoComment=data.data
					$("#articleComment").zyComment({
						"agoComment":agoComment
					});
					}
					
				})
			}
		})
		
	
	</script>
	<script>


	

//苹果的回调
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
	
		
    $(".ios-rad").click(function(){
    	var labelid=$(this).attr("labelid")
        bridge.callHandler('labeltiao',{Id:labelid},function  (response) {
        	
        	console.log('JS got response', response)
    	});
     });
     
    $("body").on("click",".sf_id",function(){
    	var sf_id=$(this).find(".backpic-wrap").attr("status_id")
    	console.log(sf_id)
        bridge.callHandler('sf_id',{Id:sf_id},function  (response) {
        	
        	console.log('JS got response', response)
    	});
     });
})
 
//安卓的回调	
		 var ua = navigator.userAgent.toLowerCase();
		    if (ua.match(/Android/i) == "android") {
			    $(".bor-rad").click(function  () {
				  	var labelid=$(this).attr("labelid")	
					window.yuhaodong.startYHD(labelid)
				})
		         $(".sf_id").click(function  () {
				  	var sf_id=$(this).find(".backpic-wrap").attr("status_id")
					window.yuhaodong1.startYHD1(status_id)
				})
		    }
		
	</script>
</html>
