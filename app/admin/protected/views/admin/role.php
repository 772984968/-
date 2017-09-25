<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '美影管理系统-管理员列表';
?>
<style>
    body {overflow-x:hidden; background-color: #eff3f6;}
</style>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href="">角色列表</a>
		</div>
		<div class="button-group float-right">
			<a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['addRole']);?>"> 添加角色组</a> 
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
                        <th width="100">id</th>
                        <th width="*">角色名</th>
                        <th width="*">创建时间</th>
                        <th width="*">状态</th>
                        <th width="*">操作</th>
                    </tr>
					<?php if(is_array($data)&&!empty($data)) :?>
						<?php foreach($data as $v) :?>
							<tr>
								<td><?php echo isset($v['id']) ? $v['id'] : '';?></td>
								<td><?php echo isset($v['group_name']) ? $v['group_name'] : '';?></td>
								<td><?php echo isset($v['create_time']) ? date('Y-m-d H:i:s', $v['create_time']) : '';?></td>
								<td>
									<?php if($v['state']):?>
										<span class="tag bg-green">正常</span>
									<?php else:?>
										<span class="tag bg-red">禁用</span>
									<?php endif;?>
								</td>
								<td>
                                <?php if($v['is_admin']): ?>
                                    <a class="button bg-blue button-small" disabled="disabled" title="禁止操作">禁止操作</a>
                                <?php else: ?>
                                    <?php if(in_array('upRole', $power)):?>
    									<a class="button bg-blue button-small icon-pencil" href="<?php echo url::toRoute(yii::$app->params['url']['upRole']);?>?id=<?php echo isset($v['id']) ? $v['id'] : '';?>" title="修改"></a>
    								<?php endif; ?>
                                    <?php if(in_array('delRole', $power)):?>
                                        <a class="button bg-red button-small icon-trash-o js-del" href="javascript:;" url="<?php echo url::toRoute(yii::$app->params['url']['delRole']);?>?isCsrf=0" data="<?php echo isset($v['id']) ? $v['id'] : '';?>" title="删除"></a>
    								<?php endif ?>
                                <?php endif; ?>
                                </td>
							</tr>
						<?php endforeach;?> 
					<?php endif;?>
                </tbody>
            </table>
			<?php echo html::endForm();?>
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
	});
</script>
