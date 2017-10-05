<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '卡客文章管理';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href=""> 文章列表</a>
		</div>
		<div class="button-group float-right">
		<?php if(in_array('addarticle', $power)):?>
			<a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['addarticle']);?>">添加</a>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
		<div class="table-tools clearfix">
			<div class="float-left">
				<?php echo html::beginForm(Url::toRoute(yii::$app->params['url']['articlelist']), 'GET');?>
				<div class="form-inline">
					<div class="form-group">搜索： </div>
					<div class="form-group">
						<div class="field">
							<select class="input" name="search[type]" id="class_id">
								<option value=>请选择</option>
								<?php if(!empty($search) && is_array($search)) :?>
									<?php foreach($search as $k=>$v):?>
										<option value="<?= Html::encode($k)?>" <?php if (isset($searchvalue['type']) && $searchvalue['type'] == $k)  echo "selected"?> ><?= Html::encode($v)?></option>
									<?php endforeach;?>
								<?php endif;?>
							</select>
						</div>
					</div>
					<div class="form-group" style="margin-left: 10px;">
						<div class="field">
							<input type="text" class="input" id="keyword" name="search[keyword]" size="30" value="<?php echo isset($searchvalue['keyword'])?$searchvalue['keyword']: '';?>" placeholder="关键词">
						</div>
					</div>
					<div class="form-group">分类：</div>
					<div class="form-group" style="margin-left: 10px;">
						<div class="field">
							<select name="search[cat_id]" id="cat_id" class="input">
								<option value="0">==请选择==</option>
								<?php foreach ($category as $k => $v):?>
									<option value="<?php echo isset($v['cat_id']) ? $v['cat_id'] : '';?>" <?php if (isset($searchvalue['cat_id']) && $searchvalue['cat_id'] == $v['cat_id'])  echo "selected"?>>
										<?php echo isset($v['cat_name']) ? $v['cat_name'] : '';?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="form-group" style="margin-left: 10px;">添加时间：</div>
					<div class="form-group">
						<div class="field">
							<?php echo html::textInput('search[stime]',isset($searchvalue['stime'])?$searchvalue['stime']: null, ['class' => 'input', 'size' => 25, 'id' => 'stime', 'placeholder' => '开始时间']); ?>
							<?php echo html::textInput('search[etime]',isset($searchvalue['etime'])?$searchvalue['etime']: null, ['class' => 'input', 'size' => 25, 'id' => 'etime', 'placeholder' => '结束时间']); ?>
						</div>
					</div>
					<div class="form-button">
						<button class="button" type="submit">查询</button>
					</div>
				</div>
				<?php echo html::endForm();?>
			</div>
		</div>
		<div class="table-responsive">
			<table id="table" class="table table-hover ">
				<tbody>
					<tr>
						<th>文章ID</th>
						<th>文章标题</th>
						<th>文章分类</th>
						<th>添加时间</th>
						<!--<th>是否显示</th>
						<th>是否热门文章</th>
						<th>是否推荐文章</th>
						<th>排序</th>-->
						<th>操作</th>
					</tr>
					<?php if(is_array($data)&&!empty($data)) :?>
						<?php foreach($data as $v) :?>
							<tr>
								<td>T<?= Html::encode($v->id)?></td>
								<td><?= Html::encode($v->title)?></td>
								<td><?php if(isset($v->cate->cat_name)):?><?= Html::encode($v->cate->cat_name)?><?php endif;?></td>
								<td><?= Html::encode(date('Y-m-d H:i:s',$v->create_time))?></td>
								
								<td>
									<?php if(in_array('editarticle', $power)):?>
										<a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url']['editarticle']);?>?id=<?= Html::encode($v->id)?>" title="修改">修改</a>
									<?php endif; ?>
									<?php if(in_array('delarticle', $power)):?>
									 	<a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url']['delarticle']);?>?isCsrf=0" data="<?= Html::encode($v->id)?>" title="删除">删除</a>
									<?php endif; ?>
									<?php if(in_array('pusharticle', $power)):?>
										<a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url']['pusharticle']);?>?id=<?= Html::encode($v->id)?>" title="发布">发布</a>
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
		$('#stime').duxTime();
		$('#etime').duxTime();
	});
</script>