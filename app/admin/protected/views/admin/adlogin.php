<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '美影管理系统-管理员登录日志';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href="">管理员登录日志</a>
		</div>
	</div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
	<div class="table-tools clearfix">
        <div class="float-left">
			<?php echo html::beginForm(Url::toRoute(yii::$app->params['url']['adminLogin']), 'GET');?>
                <div class="form-inline">
					 <div class="form-group">搜索： </div>
					 <div class="form-group">
                        <div class="field">
                            <select class="input" name="search[type]" id="class_id">
                              <option value=>请选择</option>
							  <?php if(!empty($search) && is_array($search)) :?>
							  <?php foreach($search as $k=>$v):?>
							  <option value="<?= Html::encode($k)?>"><?= Html::encode($v)?></option>
							  <?php endforeach;?>
							  <?php	endif;?>
						 </select>
                        </div>
                    </div>
					<div class="form-group" style="margin-left: 10px;">
                        <div class="field">
                            <input type="text" class="input" id="keyword" name="search[keyword]" size="30" value="" placeholder="关键词">
                        </div>
                    </div>
					<div class="form-group" style="margin-left: 10px;">起止时间：</div>
					 <div class="form-group">
                        <div class="field">
                            <input type="text" class="input js-time" id="stime" name="search[stime]" size="25" value="" placeholder="开始时间">
							<input type="text" class="input js-time" id="etime" name="search[etime]" size="25" value="" placeholder="结束时间">
                        </div>
                    </div>
                    <div class="form-button">
                        <button class="button" type="submit">查询</button>
						<?php if(in_array('eadlogin', $power)): $search = (!empty($_GET['search']) ? $_GET['search'] : '')?>
						<?php echo "<a class='button' href='".Url::toRoute([yii::$app->params['url']['eadlogin'], 'search'=>$search])."'>导出</a>";?>
						<?php endif;?>
                    </div>
                </div>
            <?php echo html::endForm();?>
        </div>
    </div>
	<div class="table-responsive">
		<table id="table" class="table table-hover ">
			<tbody>
				<tr>
					<th width="10%">ID</th>
					<th width="10%">管理员ID</th>
					<th width="10%">登录账号</th>
					<th width="15%">登陆ip</th>
					<th width="10%">登陆时间</th>
				</tr>
				<?php if(is_array($data)&&!empty($data)) :?>
					<?php foreach($data as $v) :?>
						<tr>
							<td><?= Html::encode($v->id)?></td>
							<td><?= Html::encode($v->uid)?></td>
							<td><?= Html::encode($v->account)?></td>
							<td><?= Html::encode($v->login_ip)?></td>
							<td><?= Html::encode(date('Y-m-d H:i:s', $v->login_time))?></td>
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
		$('#form').duxFormPage();
        $('#stime').duxTime();
        $('#etime').duxTime();
	});
</script>