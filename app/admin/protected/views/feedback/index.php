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
						<th>用户名</th>
						<th>联联号</th>
						<th>内容</th>
						<th>时间</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($data)&&!empty($data)) :?>
						<?php foreach($data as $v) :?>
							<tr>
								<td><?= Html::encode($v->feedback_id)?></td>
							    <td><?= Html::encode($v->userinfo->username)?></td>
						      	<td><?= Html::encode($v->userinfo->llaccounts)?></td>
								<td><?= Html::encode(mb_substr($v->content,0,5)).'...'?></td>
								<td><?= Html::encode(date('Y-m-d H:i:s',$v->create_time))?></td>
								<th><a class="button bg-blue button-small icon-eye" onclick="details('<?= Html::encode($v->content)?>')" title="查看反馈详情"></a><a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="/feedback/del?isCsrf=0" data="<?= Html::encode($v->feedback_id)?>" title="删除"></a></th>
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
<script>
function details(content){
	layer.open({
		  type: 1,
		  title: false,
		  area: ['700px', '460px'],
		  closeBtn: 1,
		  shadeClose: true,
		  skin: 'layui-layer-lan',
		  content: "<div><p style='font-size: 20px;color: gray;'  align='center'>具体反馈内容</p><p style='font-size: 15px;color: gray;width:650px;'>&nbsp;&nbsp;&nbsp;&nbsp;"+content+"</p></div>"
		});
}

</script>

