<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '菜单列表';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            
        </div>
        <div class="button-group float-right">
            <a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url'][$config['addUrl']]);?>"> 添加</a>
        </div>
    </div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
        <div class="table-responsive">
            <?= $data ?>
        </div>
        
    </div>
</div>
<script>
    Do.ready('base', function () {
        $('#table').duxTable();
    });
$(function(){
    var isShow = false;
    $('a.a-btn').on('click', function(e){
        var tr = $(this).parents('tr.trshow'), down = 'icon-plus-square', right = 'icon-minus-square';

        var trid = $(this).parent().parent().attr("trid");
        var trs = $("tr[pid='"+trid+"']");
        if($(this).hasClass(down)){ 
            isShow = false;
            trs.show();
            $(this).removeClass(down).addClass(right);
        }else{
            isShow = true;
            hideChileTr(trid)
            $(this).removeClass(right).addClass(down);
        }
        

        e.stopPropagation();
    });
    
    function hideChileTr(pid)
    {
        var trs = $("tr[pid='"+pid+"']");
        trs.each(function(i){
            trid = $(this).attr('trid');
            hideChileTr(trid);
            down = 'icon-plus-square', right = 'icon-minus-square';
            if($(this).find("a.a-btn").hasClass(right))
            {
                $(this).find("a.a-btn").removeClass(right).addClass(down);
            }
            $(this).hide();
        });
    }
    

})
</script>