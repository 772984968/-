<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>次元纪 - 让次元连接你们</title>
		<link rel="shortcut icon" href="/assets/images/erci.ico" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" type="text/css" href="/assets/css/normalize.css"/>
		<link rel="stylesheet" href="/assets/css/upload.css" />
		<link rel="stylesheet" href="/assets/layui/css/layui.css" />
		<link rel="stylesheet" href="/assets/css/webuploader.css" />
		<style type="text/css">

		</style>
	</head>
	<body>
			<div class="upload-wrap">
				<div class="upload-head">
					<p>
						<img src="/assets/images/lll_02.png"/>
						<span><a href="/index/index">首页</a></span>
					</p>
					
				</div>
				<div class="upload-content">
					<div class="ssss">
					<div id="upimg">
						<!--<img src="" class="img-src">-->
						<p id="ooo"   style="margin: 0;">
							上传封面
							
						</p>
					</div>
					<div class="up-r">
						<div id="up-vid">
							<p id="uuu" style="margin: 0;">
								添加文件
							</p>
						</div>
							
						<div id="jqmeter-container" style="margin-left: 35px;">
							<div class="layui-progress layui-progress-big"  lay-filter="demo" lay-showPercent="true">
							   <div class="layui-progress-bar layui-bg-orange" lay-percent="0%"></div>
							</div>
						</div>
						
						<p class="aaaa bb">封面尺寸≥960*600，≤3MB，JPG,JPEG,PNG格式</p>
						<p class="aaaa">支持单个主流视频格式（MP4、MPEG、MOV、WMV等）格式文件除FLV，大小不能超过2G</p>
					</div>
					</div>
					
					<div class="nrr">
						<div class="lll">
							<span class="vvv">视频分类</span>
							<div class="ooo">
							<input type="radio" name="ss" class="cs-sel" value="3" style="display: none;">
							<img src="/assets/images/sel-yes.png" class="type-a"><span>舞蹈</span>
							</div>
							
							<div>
							<input type="radio" name="ss" class="cs-sel" value="4" style="display: none;">
							<img src="/assets/images/sel-no.png" class="type-b"><span>音乐</span>
							</div>
		
						</div>
						<p><span class="vvv">视频标题</span><input type="text" placeholder="按回车完成输入" class="v-title"></p>
						<p><span class="vvv" style="float: left; margin-top: 10px;">视频简介</span><textarea type="text" maxlength="250" placeholder="按回车跳行，最多输入250个字" class="v-ps"  ></textarea></p>
						<p><span class="vvv">增加标签</span><input type="text" placeholder="按回车添加标签，最多只能增加五条" class="v-addtitle"></p>
						<p class="lab-wrap" style="margin-left: 53px;">
						</p>
						
					</div>
					<div class="iii">
					<p class="qrfb">确定发布</p>
					</div>
					<ul>
						<li class="ppp">*请尽量保证视频大小在1G内，保证视频的流畅清晰度；</li>
						<li class="ppp">*请遵守视频上传协议，禁止上传色情暴力等违法违规视频；</li>
						<li class="ppp">*如视频出现违规,广告无关等因素，工作员将警告并删除视频：</li>
					</ul>
				</div>
			</div>
	</body>
	<script src="/assets/js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/js/uploadpage.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/js/webuploader.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/layer/layer.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/layui/layui.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
			layui.use('element', function(){
			  window.element = layui.element();
			});

	
	
	
//=========================上传图片的=================================//
		var uploader1 = WebUploader.create({
		 	auto: true,
		    // swf文件路径
		    swf: '/assets/js/Uploader.swf',
			name: 'abcd',
		    // 文件接收服务端。
		    server: '/upload/file',
			fileSingleSizeLimit: 3*1024*1024,//限制大小3M，单文件
		    // 选择文件的按钮。可选。
		    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
		    pick:{
		    	id:'#ooo',
		    	innerHTML :'上传封面'
							    	
		    },
		    
		
		    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
		    resize: false,
		    accept: {
		        title: 'Images',
		        extensions: 'jpg,jpeg,png',
		        mimeTypes: 'image/jpg,image/jpeg,image/png'
	    	}
		});
		
		uploader1.on( 'uploadSuccess', function( file,response ) {
		   $("#ooo").text("上传成功")
		   console.log(file)
		   if (response.message=="no login") {
		   		layer.msg('请先登录', function(){
		   			window.location.href="/index/login"
		   		});
		   }
		   $("#ooo").remove()
		   $("#upimg").append('<img src="'+response.data.url+'" class="img-src">')
//		   $(".img-src").attr("src",response.data.url)
		   console.debug(response.data.url)
		   window.imageurl=response.data.url
		  
		});
		
		uploader1.on( 'uploadError', function( file ) {
		    $("#ooo").text("上传失败")
		    console.log(file)
		});

//==========================上传视频的================================//
		var uploader2 = WebUploader.create({
		 	auto: true,
		    // swf文件路径
		    swf: '/assets/js/Uploader.swf',
		    // 文件接收服务端。
		    server: '/upload/file',
		
		    // 选择文件的按钮。可选。
		    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
		    pick:{
		    	id:'#uuu',
//		    	innerHTML :'上传封面'
							    	
		    },
//		    chunked:true,
//			chunkRetry:2,
		    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
		    resize: false,
		    fileSingleSizeLimit: 2048*1024*1024,//限制大小2048M，单文件
		    accept: {
		        title: '视频上传',
	    	}
		    
		});
		uploader2.on('uploadStart',function  (file) {
			console.log("选择文件类型"+file.ext)
			if (file.ext!="mp4"&&file.ext!="MP4"&&file.ext!="mpeg"&&file.ext!="MPEG"&&file.ext!="mov"&&file.ext!="MOV"&&file.ext!="wmv"&&file.ext!="WMV"){
				layer.msg('文件类型不允许', function(){});
		   		return false;
			}
			uploader2.on( 'uploadSuccess', function( file,response) {
			   $("#uuu").text("上传成功")
			   layer.msg('视频上传成功');
			   console.log(file)
			   if (response.message=="no login") {
			   		layer.msg('请先登录', function(){
			   			window.location.href="/index/login"
			   		});
			   }
			   if (response.message=="文件类型不允许") {
			   		layer.msg('文件类型不允许', function(){
//			   			window.location.href="/index/upload"
			   		});
			   }
			   console.debug(response.data.url)
			   window.videourl=response.data.url
			});
			
			uploader2.on( 'uploadError', function( file ) {
			    $("#uuu").text("上传失败")
			});
		uploader2.on( 'uploadProgress', function( file, percentage ) {
			percentage = percentage.toFixed(4);
			var cccccc=percentage*100+'%'
			console.log("进度"+cccccc)
			$("#jqmeter-container").css("visibility","visible")
			element.progress('demo', cccccc);
		 	$("#uuu").text("视频正在上传....")
		});
		})
		

			
		// 文件上传过程中创建进度条实时显示。
		


	</script>
</html>	