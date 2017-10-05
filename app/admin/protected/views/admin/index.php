<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '美影管理系统-管理员列表';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href=""> 管理员列表</a>
		</div>
		<div class="button-group float-right">
			<a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['addAdmin']);?>"> 添加管理员</a> 
		</div>
	</div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
		<div class="table-responsive">
			<table id="table" class="table table-hover ">
				<tbody>
					<tr>
						<th>ID</th>
						<th>管理员账号</th>
						<th>权限组</th>
						<th>管理员昵称</th>
						<th>邮箱</th>
						<th>联系电话</th>
						<th>时间</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($data)&&!empty($data)) :?>
						<?php foreach($data as $v) :?>
							<tr>
								<td><?= Html::encode($v->id)?></td>
								<td><?= Html::encode($v->account)?></td>
								<td><?= isset($v->group->group_name) ? Html::encode($v->group->group_name) : ''?></td>
								<td><?= Html::encode($v->nickname)?></td>
								<td><?= Html::encode($v->email)?></td>
								<td><?= Html::encode($v->phone)?></td>
								<td><?= Html::encode(date('Y-m-d H:i:s', $v->uptime))?></td>
								<td>
									<?php if(1==$v->state):?>
										<span class="tag bg-green">正常</span>
									<?php else:?>
										<span class="tag bg-red">禁用</span>
									<?php endif;?>
								</td>
								<td>
									<?php if(isset($v->group->is_admin) && Html::encode($v->group->is_admin)!=1) :?>
										<?php if(in_array('upAdmin', $power)):?>
											<a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url']['upAdmin']);?>?id=<?= Html::encode($v->id)?>" title="修改"></a>
										<?php endif; ?>
										<?php if(in_array('delAdmin', $power)):?>
										 	<a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url']['delAdmin']);?>?isCsrf=0" data="<?= Html::encode($v->id)?>" title="删除"></a>
										<?php endif; ?>
									<?php else:?>
										<a class="button bg-blue button-small" disabled="disabled" title="禁止操作">禁止操作</a>
									<?php endif;?>
								</td>
							</tr>
						<?php endforeach;?>	
					<?php endif;?>
				</tbody>
			</table>
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