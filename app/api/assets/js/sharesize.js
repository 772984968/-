
function setFont() {
		var HTML=document.getElementsByTagName('html')[0];
		/*var dpr=1;//像素比
		var Size=document.documentElement.clientWidth*dpr/10;*/
		//把viewport视口分成10份的rem,html的font-size为1rem
		var Size=document.documentElement.clientWidth/10;
		if (Size>=92) {
			Size=92
		}
		HTML.style.fontSize=Size+'px';
		
		
	};
	setFont();//初始适配
	window.onresize=function () {//窗口大小改变适配
		setFont();
	};
	
		

	
	