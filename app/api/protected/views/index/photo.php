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
		<link rel="stylesheet" href="/assets/css/photo.css" />
		<link rel="stylesheet" type="text/css" href="/assets/css/photoswipe.css"/>		
		<link rel="stylesheet" type="text/css" href="/assets/css/default-skin/default-skin.css"/>
		<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
		
	</head>
	<body>
		<div style="width: 10rem; margin:  0 auto;">
			
		
		<div class="head-top">
			<div class="down-app">
				使用APP浏览
			</div>
		</div>
		<div class="home-wrap">
			<div class="home-head" <?php if($result['userinfo']['icon']):?> style="background:url('<?= html::encode($result['userinfo']['icon'])?>') no-repeat; background-size:100% 100%;"  "<?php endif;?>>
				<p class="home-img"><span><img src="<?php if($result['userinfo']['icon']):?><?= Html::encode($result['userinfo']['icon']) ?> <?php else: ?>/assets/images/home_02.jpg<?php endif;?>" alt="" /></span></p>
				<p class="home-name">
						<span><?= html::encode($result['userinfo']['nickname']) ?></span>
						<?php if($result['userinfo']['sex']=='男'): ?>
							<img src="/assets/images/hoxb_03.png" alt="" />
						<?php else: ?>
							<img src="/assets/images/20170414113228.png" alt="" />
						<?php endif;?>
				</p>
				<p class="home-sf"><span><?= html::encode($result['userinfo']['status']) ?></span></p>
				<p class="home-xx"><span><?= html::encode($result['userinfo']['site']) ?></span><span><?= html::encode($result['userinfo']['height']) ?>cm</span><span><?= html::encode($result['userinfo']['weight']) ?>KG</span></p>
				<p class="home-js"><?= html::encode($result['userinfo']['intro']) ?></p>
				<p class="home-j"><span>+关注</span></p>
			</div>
			<div class="cont-wrap">
				<p class="status">***</p>
				<p class="find"><span >—&nbsp;&nbsp;FIND&nbsp;&nbsp;—</span></p>
				<p class="zdy">*********</p>
			</div>
			<div class="mui-content-padded" data-pswp-uid="1" style="overflow: hidden;">	
				
			</div>
			<div class="yuy-wrap">
				<p>
					<span class="yutime">
						预约时间：
						<span class="start_time"></span>~
						<span class="end_time"></span>
					</span>
					<span class="fon-w"><span class="jie"></span>/天</span>
				</p>
				<p><span class="yuadd">预约地点：<span class="addr">***</span></span></p>
			</div>
			<div class="xx-wrap">
				<p>
					<img src="<?= Html::encode($result['userinfo']['icon']) ?>" alt=""  class="toux">
					<span class="nickname-p"><?= Html::encode($result['userinfo']['nickname']) ?></span>
					<?php if($result['userinfo']['sex']=='男'): ?>
							<img src="/assets/images/hoxb_03.png" alt="" class="sex">
						<?php else: ?>
							<img src="/assets/images/20170414113228.png" alt="" class="sex">
					<?php endif;?>
					<img src="/assets/images/a_05.png" alt=""  class="aa">
					<img src="/assets/images/a_03.png" alt=""  class="aa">
				</p>
				<p class="pl">来到次元界<span class="tiannum">0</span>天了，发布作品<span class="taonum">0</span>套，接单<span class="cinum">0</span>次。</p>
				<p class="pl2">好评<span class="haonum" >0</span>次，差评<span class="chanum">0</span>次</p>
			</div>
			<div>
				
			</div>
			<div class="cont-wrap">
				<p class="status1">评论</p>
				<p class="find"><span >—&nbsp;&nbsp;LEAVE WORD&nbsp;&nbsp;—</span></p>
				<!--<div class="pl-conter">
					<p><img src="" class="pl-icon"><span></span><img src=""><span>20</span></p>
					<p>评论内容</p>
					<p><span>#</span><span></span></p>
				</div>-->
			</div>
		</div>
		<div class="head-bottom">
			<div class="down-open">
				马上下载
			</div>
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
</div>
</body>
	<script src="/assets/js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/js/sharesize.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/js/photoswipe-ui-default.min.js" type="text/javascript"></script>
	<script src="/assets/js/photoswipe.js" type="text/javascript"></script>
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
	
</script>

	<script>
		var id = '<?= intval(\Yii::$app->request->get('id')) ?>';
		var token = '<?= \YII::$app->request->get('token') ?>';
		var userid = '<?= \YII::$app->request->get('userid') ?>';
		$(window).load(function  () {
			
			$.get("/status/statuspageinformation?id="+id+"&token="+token+"&userid="+userid+"",function  (data) {
				console.table(data)
				
				for (var a in data.data.images) {
					var imgw=""
					imgw+='<figure><span><a href="'+data.data.images[a].source+'" data-size="0x0"><img  src="'+data.data.images[a].source+'" style="width: 10rem; float:left;"></a></span></figure>'
					console.log(imgw)
					$(".mui-content-padded").append(imgw)
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

				}
//				for (var a in data.data.ordercomment) {
//					var plcc=""
//					plcc+='<div class="pl-conter"><p><img src="'+data.data.ordercomment[a].icon+'" class="pl-icon"><span>'+data.data.ordercomment[a].nickname+'</span><img src=""><span>20</span></p>'
//					plcc+='<p>'+data.data.ordercomment[a].comment_text+'</p><p><span>#</span><span></span></p></div>'
//					$(".cont-wrap").append(plcc)
//				}
				
				console.table(data.data.images)
				switch (data.data.status){
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
				var date = new Date(data.data.start_dt*1000);
				M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '月';
				D = date.getDate() + '日';
				h = date.getHours();
				if (h<=9) {
					h='0'+date.getHours()+':'
				} else{
					h=date.getHours()+':'
				}
				m = date.getMinutes();
				if (m<=9) {
					m='0'+date.getMinutes()
				} else{
					m=date.getMinutes()
				}
				var riqi =M+D+h+m
				console.log(riqi); //呀麻碟
				$(".start_time").text(riqi)
				var date = new Date(data.data.end_dt*1000);
				M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '月';
				D = date.getDate() + '日';
				h = date.getHours();
				if (h<=9) {
					h='0'+date.getHours()+':'
				} else{
					h=date.getHours()+':'
				}
				m = date.getMinutes();
				if (m<=9) {
					m='0'+date.getMinutes()
				} else{
					m=date.getMinutes()
				}
				var riqi =M+D+h+m
				console.log(riqi); //呀麻碟
				$(".end_time").text(riqi)
				$(".addr").text(data.data.address)
				$(".status").text(status)
				$(".zdy").text(data.data.content)
				$(".tiannum").text(data.data.userinfo.day_number)
				$(".taonum").text(data.data.productcount)
				$(".cinum").text(data.data.order)
				$(".jie").text(data.data.money)
				$(".toux").attr("src",data.data.userinfo.icon)
				$(".haonum").text(data.data.good_reputation)
				$(".chanum").text(data.data.bad_reputation)
				$(".nickname-p").text(data.data.userinfo.nickname)
				
			})
		})
		
	</script>
</html>
