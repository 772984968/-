<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<div>
<form action="<?php echo Url::toRoute(yii::$app->params['url'][$config['invUrl']]);?>" method="post">
	<div class="form-group" style="margin-left: 10px;">查询筛选：</div>
					<div class="form-group">
						<div class="field">
							<?php echo html::textInput('search[stime]',isset($searchvalue['stime'])?$searchvalue['stime']: null, [ 'size' => 25, 'id' => 'stime', 'placeholder' => '开始时间']); ?>
							<?php echo html::textInput('search[etime]',isset($searchvalue['etime'])?$searchvalue['etime']: null, [ 'size' => 25, 'id' => 'etime', 'placeholder' => '结束时间']); ?>
						<input type="hidden" value="<?php echo $id ?>" name="id">
						<label for="name">查询类型：</label>:
							<select class="form-control" name="search[vip_type]">
                                  <option value="">--查询类型--</option>
                                  <option value="5" <?php if (isset($searchvalue['vip_type'])&&$searchvalue['vip_type']==5) echo "selected='selected'"?>>--VIP会员--</option>
                                  <option value="0" <?php if (isset($searchvalue['vip_type'])&&$searchvalue['vip_type']==0) echo "selected='selected'"?>>--非会员--</option>
                            </select>
						</div>
					</div>
					<div class="form-button">
						<button  type="submit" class="button">查询</button>
						<button class="button win-back icon-arrow-left"  type="button">返回</button>
					</div>
</form>
<div class="panel-foot table-foot clearfix">
            <!-- 分页 start-->
            <?php
//             echo LinkPager::widget([
//                 'pagination' => $pagination,
//                 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页','firstPageLabel' => '首页', 'lastPageLabel'=>'尾页',
//                 ]);
            ?>
         <?php

         ?>
<p>邀请人数：<?= count($invites) ?></p>
<p>充值钻石总数：<?= $diamondtotal?></p>
            <!-- 分页 end-->
        </div>

</div>


	<table class="table table-hover">
		<caption>用户<?php echo $username?>邀请列表</caption>
		<thead>
			<tr>

				<th>ID</th>
				<th>账号</th>
				<th>联联账号</th>
				<th>VIP类型</th>
				<th>代理</th>
				<th>被邀请人</th>
				<th>注册时间</th>
				<th>现金</th>
				<th>钻石</th>
				<th>已充值钻石</th>
			</tr>
		</thead>
		<tbody>
  <?php if (!empty($invites)):?>
  <?php foreach ($invites as $key => $value):?>
    <tr>
				<td><?= $value['iid']?></td>
				<td><a href="<?php echo Url::toRoute(yii::$app->params['url'][$config['invUrl']]);?>?id=<?= Html::encode($value['iid'])?>"><?= Html::encode($value['username'])?></a></td>
				<td><?= Html::encode( $value['llaccounts'])?></td>
				<td><?php if ($value['vip_type']==5)echo 'VIP会员';else echo '非会员'?></td>
				<td><?=$value['agentinfo']['name']?></td>
				<td><?php echo $value['inviteCode'];?></td>
				<td><?php echo $value['created_at'];?></td>
				<td><?php echo $value['wallet'];?></td>
				<td><?php echo $value['diamond'];?></td>
				<td><?php echo ($value['diamondsum']);?></td>
				</tr>
    <?php endforeach;?>
     <?php else: ?>
    <tr><td align="center"colspan = " 9 ">暂无记录！</td></tr>
       <?php endif;?>
  </tbody>
	</table>

<script>
	Do.ready('base', function () {
		$('#table').duxTable();
		$('#stime').duxTime();
		$('#etime').duxTime();
	});
</script>