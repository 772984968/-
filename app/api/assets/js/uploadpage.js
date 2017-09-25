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
$(".v-ps").keyup(function(){
        if(event.keyCode == 13){
            $(".v-addtitle").focus()
        }
});

$(".qrfb").click(function  () {
	
	var ProductForm = {};
	ProductForm['title'] =q ;
	ProductForm['content'] = t3;
	ProductForm['classify'] = t3;
	ProductForm['label'] = t3;
	var json = {ProductForm};
	$.post("/product/add",json,function  (data) {
		console.log(data)
		
	}
})
						
$(".v-addtitle").keyup(function(){
        if(event.keyCode == 13){
            
        }
});