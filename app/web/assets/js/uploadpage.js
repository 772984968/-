

	$(".type-a").click(function  () {
	if ($(this).attr("src")=="/assets/images/sel-yes.png") {
		$(this).attr("src","/assets/images/sel-no.png")
		$(".type-b").attr("src","/assets/images/sel-yes.png")
	}
	else{
		$(this).attr("src","/assets/images/sel-yes.png")
		$(".type-b").attr("src","/assets/images/sel-no.png")
	}
})
$(".type-b").click(function  () {
	if ($(this).attr("src")=="/assets/images/sel-no.png") {
		$(this).attr("src","/assets/images/sel-yes.png")
		$(".type-a").attr("src","/assets/images/sel-no.png")
	}
	else{
		$(this).attr("src","/assets/images/sel-no.png")
		$(".type-a").attr("src","/assets/images/sel-yes.png")
	}
})
$(".v-title").keyup(function(){
        if(event.keyCode == 13){
            $(".v-ps").focus()
        }
});
//$(".v-ps").keyup(function(){
//      if(event.keyCode == 13){
//          $(".v-addtitle").focus()
//      }
//});
var niec=[]
$(".v-addtitle").keyup(function(){
	
	if(event.keyCode == 13){
         	
           if($(".lab-wrap").children().length>=5){
           	layer.msg('最多只能添加五个标题', function(){});
           return false;
           }
          
           if ($(".v-addtitle").val()=="") {
           	layer.msg('请不要添加空的标签', function(){});
           	return false;
           }
             $(".lab-wrap").append('<span class="lab-el">'+$(".v-addtitle").val()+'<img src="/assets/images/xx.png" alt="" class="xxx" ></span>')
             niec.push($(".v-addtitle").val())
            console.log(niec)
          	$(".v-addtitle").val("")
          	
        }

	
	
});

//===========================删除数组中的指定元素===========================
Array.prototype.indexOf = function(val) {              
    for (var i = 0; i < this.length; i++) {  
        if (this[i] == val) return i;  
    }  
    return -1;  
}; 
Array.prototype.remove = function(val) {  
    var index = this.indexOf(val);  
    if (index > -1) {  
        this.splice(index, 1);  
    }  
};  
//===========================删除数组中的指定元素=========================
$("body").on("click",".xxx",function(){
	var c=$(this).parent(".lab-el").text()
	$(this).parent(".lab-el").remove()
	niec.remove(c); 
})

$(".v-ps").keyup(function  () {
	if ($(".v-ps").val().length>="250") {
		layer.msg('你输入的太多了', function(){
			
		});
	}
})

$(".qrfb").click(function  () {
	var classify=$("[src='/assets/images/sel-yes.png']").prev("input").val()
	var title=$(".v-title").val()
	if ($(".v-title").val()=="") {
		layer.msg('标题不能为空', function(){});
		return false;
	} 
	var content=$(".v-ps").val()
	if ($(".v-ps").val()=="") {
		layer.msg('视频简介不能为空', function(){});
		return false;
	}
	 if($(".lab-wrap").children().length==0){
           	layer.msg('请添加标签', function(){});
           	return false;
    }
	 if("undefined" == typeof imageurl){
		layer.msg('请先上传封面', function(){	
		});
		return false;
	}
	
	if("undefined" == typeof videourl){
		layer.msg('请先上传视频', function(){});
		return false;
	}
	niec=JSON.stringify(niec);
    console.log(niec)



	var ProductForm = {};
	ProductForm['title'] =title;
	ProductForm['content'] = content;
	ProductForm['classify'] = classify;
	ProductForm['label'] =niec;
	ProductForm['type']="5"	
	ProductForm['video']=videourl
	ProductForm['images']=imageurl;
	var json = {ProductForm};
	$.post("/product/addvideo",json,function  (data) {
		console.log(data)
		if(data.message=="ok")
		{
			layer.msg('发布成功', function(){	
				window.location.href="/index/upload"
		});
		}
	})
})
						





