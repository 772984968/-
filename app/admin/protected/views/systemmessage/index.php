<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href=""> 系统信息</a>
		</div>
		<div class="button-group float-right">
			<?php if(in_array('systemmessageadd', $power)):?>
			<a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['systemmessageadd']);?>">添加</a>
			<?php endif;?>
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
						<th>标题</th>
						<th>内容</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($data)&&!empty($data)) :?>
						<?php foreach($data as $v) :?>
							<tr>
								<td><?= Html::encode($v->message_id)?></td>
								<td><?= Html::encode($v->title)?></td>
								<td><?= Html::encode($v->content)?></td>
								<td>				
									<?php if(in_array('systemmessageupdate', $power)):?>
										<a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url']['systemmessageupdate']);?>?id=<?= Html::encode($v->message_id)?>" title="修改"></a>
									<?php endif; ?>
									<?php if(in_array('systemmessagedel', $power)):?>
									 	<a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url']['systemmessagedel']);?>?isCsrf=0" data="<?= Html::encode($v->message_id)?>" title="删除"></a>
									<?php endif; ?>

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