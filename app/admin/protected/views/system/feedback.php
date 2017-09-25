<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '卡客管理系统-反饋列表';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="">意见反馈</a>
        </div>
      
    </div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
        <div class="table-responsive">
        <?php echo html::beginForm('', 'GET', ['id' => 'tableForm']);?>
            <table id="table" class="table table-hover">
                <tbody>
                    <tr class="trshow">
                        <th>ID</th>
                        <th>电话/邮箱</th>
						<th>内容</th>
                        <th>添加时间</th>
                    </tr>
                    <?php if(is_array($data) && !empty($data)) :?>
                        <?php foreach($data as $k => $v) :?>
                            <tr>
                                <td><?= Html::encode($v['id'])?></td>
                                <td><?= Html::encode($v['phone'])?></td>
                               	<td><?= Html::encode($v['content'])?></td>
                                <td><?= $v['addtime'] >0 ? date('Y-m-d H:i:s', $v['addtime']) : '';?></td>                      
                                <td>
                                </td>
                            </tr>
                        <?php endforeach;?> 
                    <?php endif;?>
                </tbody>
            </table>
            <?php echo html::endForm(); ?>
        </div>
        <div class="panel-foot table-foot clearfix">
            <!-- 分页 start-->
                <?= $this->render('../_page', ['count' => $count, 'page' => $page]) ?>
            <!-- 分页 end-->
        </div>
    </div>
</div>
<script>
    Do.ready('base', function () {
        $('#table').duxTable();
        $('#stime').duxTime();
        $('#etime').duxTime();
    });
</script>