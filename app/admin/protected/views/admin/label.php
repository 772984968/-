<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '美影管理系统-标签列表';
?>
<style>
    body {overflow-x:hidden; background-color: #eff3f6;}
</style>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href="">用户类型列表</a>
		</div>
	</div>
</div>
<div class="admin-main">
    <div class="panel dux-box">

        <div class="table-responsive">
			<?php echo html::beginForm();?>
            <table id="table" class="table table-hover ">
                <tbody>
                    <tr>
                        <th width="100">ID</th>
                        <th width="*">用户类型</th>
                        <th width="*">是否显示</th>
                        <th width="*">状态</th>
                        <th width="*">操作</th>
                    </tr>
					<?php if(is_array($data)&&!empty($data)) :?>
                        <?php foreach($data as $v) :?>
                            <tr <?php if($v['level'] == '0'): ?> class="trshow" <?php else: ?> style="display:none;" <?php endif; ?> >
                                <td>
                                    <?php if($v['level'] == '0') {
                                        echo '<a href="#" class="a-btn icon-plus-square">&nbsp;'.Html::encode($v['id']).'</a>';
                                    }else{
                                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".Html::encode($v['id']);
                                    } ?>
                                </td>
                                <td><?= Html::encode($v['name'])?></td>
                                <td>
                                    <?php if(1==$v['is_show']):?>
                                        <span class="tag bg-green">显示</span>
                                    <?php else:?>
                                        <span class="tag bg-red">不显示</span>
                                    <?php endif;?>
                                </td>                        
                                <td><span class="tag bg-green">正常</span>
                                </td>
                                <td>
                                    <?php 
                                        if($v['level'] == '0') {
                                            echo '<a class="button bg-blue button-small" disabled="disabled" title="禁止操作">禁止操作</a>';
                                        }else{
                                          echo '<a class="button bg-blue button-small icon-pencil" href="'.Url::toRoute(yii::$app->params['url']['upLabel']).'?id='.Html::encode($v['id']).'" title="修改"></a>';
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach;?> 
                    <?php endif;?>
                </tbody>
            </table>
            <div class="panel-foot table-foot clearfix">
                <div class="float-right">
                   共<?php echo count($data);?>条
                 </div>          
            </div>
			<?php echo html::endForm();?>
        </div>
    </div>
</div>
<script>
	Do.ready('base', function () {
		$('#table').duxTable();
	});

    $(function(){
    var isShow = false;
    $('table tr.trshow a.a-btn').on('click', function(){
        var tr = $(this).parents('tr.trshow'), down = 'icon-plus-square', right = 'icon-minus-square';
        if($(this).hasClass(down)){ 
            isShow = false;
            $(this).removeClass(down).addClass(right);
        }else{
            isShow = true;
            $(this).removeClass(right).addClass(down);
        }
        getNext(tr.next());
    });
    
    function getNext(next){
        if(!next.hasClass('trshow')){
            if(isShow){
                next.hide();
            }else{
                next.show();
            }
            next = next.next();
            getNext(next);
        }
    }

})
</script>
