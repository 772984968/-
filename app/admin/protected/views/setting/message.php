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
<div class="tools-function clearfix">

                    <div class="button-group float-right">
                <a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?= Url::toRoute('setting/addmessage'); ?>"> 添加</a>
            </div>

    </div>
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
						<th>时间</th>
						<th>操作</th>
					</tr>

					<?php  foreach ($data as $vo): ?>
					<tr>
								<td><?= $vo['iid'] ?></td>
							    <td><?= $vo['title']?></td>
						      	<td><?=$vo['content'] ?></td>
								<td><?=$vo['create_time']?></td>
								<th><a class="button bg-green button-small  icon-paper-plane"  href="<?= Url::toRoute(['setting/sendmessage','iid'=>$vo['iid']]) ?>"title="发送"></a><a class="button bg-red button-small icon-trash-o"  href="<?= Url::toRoute(['setting/delmessage','iid'=>$vo['iid']]) ?>"title="删除"></a></th>
							</tr>	<?php endforeach; ?>


				</tbody>
			</table>
		</div>
		<div class="panel-foot table-foot clearfix">
		</div>
	</div>
</div>
<script>
	Do.ready('base', function () {
		$('#table').duxTable();
	});
</script>