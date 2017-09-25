<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">

		</div>
		<div class="button-group float-right">

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
						<th>内容</th>
						<th>时间</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($data)&&!empty($data)) :?>
						<?php foreach($data as $v) :?>
							<tr>
								<td><?= Html::encode($v->feedback_id)?></td>
								<td><?= Html::encode($v->content)?></td>
								<td><?= Html::encode(date('Y-m-d H:i:s',$v->create_time))?></td>
								<th><a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="/feedback/del?isCsrf=0" data="<?= Html::encode($v->feedback_id)?>" title="删除"></a></th>
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