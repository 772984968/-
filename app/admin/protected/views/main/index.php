<?php
use app\assets\AppAsset;
use yii\helpers\Url;

$this->title = '美影管理系统';
?>
    <style>
    body,html{overflow: hidden;}
    </style>
    <div class="dux-head clearfix">
        <div class="dux-logo">
            <img src="<?=yii::$app->params['url']['staticUrl']?>images/logo.png" alt="后台管理系统" />
            <button class="button icon-navicon admin-nav-btn" data-target=".admin-nav"></button>
            <button class="button icon-navicon icon-ellipsis-v admin-menu-btn" data-target=".admin-menu"></button>
        </div>
        <div class="dux-nav">
            <ul class="nav  nav-navicon nav-inline admin-nav" id="nav">
            </ul>
            <ul class="nav  nav-navicon nav-menu nav-inline admin-nav nav-tool">
                <li> <a href="<?php echo Url::toRoute(yii::$app->params['url']['main']); ?>" class="icon-home"></a></li>
                <li> <a href="<?php echo Url::toRoute(yii::$app->params['url']['adminInfo']);?>?id=<?=$admin['id']?>" target="dux-iframe" class="icon-user"></a></li>
                <li> <a href="<?php echo Url::toRoute(yii::$app->params['url']['loginOut']); ?>" class="dux-logout bg-red icon-power-off"></a></li>
            </ul>
        </div>
    </div>

    <div class="dux-sidebar" id="sidebar-left">
        <ul class="nav  nav-navicon admin-menu">
            <div class="nav-head icon-folder-open-o" id="nav-head"></div>
            <div id="menu">
                <li><a href="" class="icon-"> </a></li>
            </div>
        </ul>
         <div id="sidebar-collapse" rel="left">
            <i class="icon-angle-double-left"></i>
        </div>
    </div>     
<div class="dux-admin" id="main-frame">
            <iframe id="dux-iframe" name="dux-iframe" class="dux-iframe" src="" frameborder="0"></iframe>
</div>

<script>
    //生成主菜单
    var data = <?php echo $menuList ?>;
    var topNav = '';
    for(var i in data){
        if(data[i]['menu'] != ''){
            if(data[i].is_show == 1)
            {
                topNav += '<li><a href="javascript:;" data="'+i+'" url="" class="icon-'+data[i].icon+'"> '+data[i].name+'</a></li>';
            }
            
        }
    }
    $('#nav').html(topNav);
    //绑定导航连接
    $('#nav').on('click','a',function(){
        //$('#nav-head').text($(this).text());
        var n = $(this).attr('data');
        var menu = data[n]['menu'];
        var menuHtml =  '';
        var nav_head_name = $(this).text();
        if(menu != ''){
            for(var i in menu){
                if(menu[i].is_show == 1)
                {
                    menuHtml += '<li>';
                    if(menu[i]['menu'])
                    {
                        nav_head_name = '';
                        menuHtml += '<div class="nav-head icon-'+menu[i].icon+'"> '+menu[i].name+' </div>';
                        var somMenu = menu[i]['menu'];
                        menuHtml += '<ul>';
                        for(var j in somMenu)
                        {
                            if(somMenu[j].is_show == 1)
                            {
                                menuHtml += '<li><a href="javascript:;" class="nav-small icon-'+somMenu[j].icon+'" url="'+somMenu[j].url+'"> '+somMenu[j].name+'&nbsp;<span class="id_'+somMenu[j].id+' text-dot"></span></a></li>';
                            }
                        }
                        menuHtml += '</ul>';
                    }
                    else
                    {
                        menuHtml += '<a href="javascript:;" url="'+menu[i].url+'" class="icon-'+menu[i].icon+'"> '+menu[i].name+'</a>';
                    }
                    menuHtml += '</li>';
                }
            }
        }
        if (nav_head_name != '')
        {
            $("#nav-head").attr("class","").addClass("nav-head " + $(this).attr("class")).text(nav_head_name).show();
        }
        else
        {
            $('#nav-head').hide();
        }
        $('#menu').html(menuHtml);
        //设置样式
        $('#nav li').removeClass('active');
        $(this).parent('li').addClass('active');
        //打开菜单
        $('#menu a:first').click();
    });
    //绑定菜单连接
    $('#menu').on('click','a',function(){
        var url = $(this).attr('url');
        $('.dux-iframe').attr('src',url);
        //设置样式
        $('#menu li').removeClass('active');
        $(this).parent('li').addClass('active');
    });
    $('#nav a:first').click();
</script>