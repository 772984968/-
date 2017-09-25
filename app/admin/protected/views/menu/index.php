<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '菜单列表';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="">菜单列表</a>
        </div>
        <div class="button-group float-right">
            <a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['addMenu']);?>"> 添加菜单</a> 
        </div>
    </div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
        <div class="table-responsive">
            <table id="table" class="table table-hover table-tr-hide">
                <tbody>
                    <tr class="trshow">
                        <th>ID</th>
                        <th >排序</th>
                        <th >菜单名称</th>
                        <th >Url</th>
                        <th >icon</th>
                        <th >是否显示</th>
                        <th >添加时间</th>
                        <th >状态</th>
                        <th >操作</th>
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
                                <td><?= Html::encode($v['order'])?></td>
                                <td><?= $v['str_repeat'].'&nbsp;'.$v['name'];?></td>
                                <td><?= Html::encode($v['url'])?></td>
                                <td><?= Html::encode($v['icon'])?></td>
                                <td>
                                    <?php if(1==$v['is_show']):?>
                                        <span class="tag bg-green">显示</span>
                                    <?php else:?>
                                        <span class="tag bg-red">不显示</span>
                                    <?php endif;?>
                                </td>
                                <td><?= Html::encode(date('Y-m-d H:i:s', $v['uptime']))?></td>                              
                                <td>
                                    <?php if(1==$v['state']):?>
                                        <span class="tag bg-green">正常</span>
                                    <?php else:?>
                                        <span class="tag bg-red">禁用</span>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <!-- update -->
                                     <a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url']['upMenu']);?>?id=<?= Html::encode($v['id'])?>" title="修改"></a>
                                    <!-- delete -->
                                    <a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url']['delMenu']);?>?isCsrf=0" data="<?= Html::encode($v['id'])?>" title="删除"></a>
                                      
                                </td>
                            </tr>
                        <?php endforeach;?> 
                    <?php endif;?>
                </tbody>
            </table>
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