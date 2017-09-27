<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use lib\models\Order;
$recordtype=Config::walletLogMeaning();
?>
<div>
<form action="<?php echo Url::toRoute(yii::$app->params['url'][$config['recordUrl']]);?>" method="post">
					<div class="form-group">
						<div class="field">
							<label for="name">开始时间：</label>:<input type="text" id="stime"  name="search[stime]" placeholder="请输入开始日期"
							 value="<?php if (isset($searchvalue['stime']))echo $searchvalue['stime'];?>">
							<label for="name">结束时间：</label>:	<input type="text" id="etime" name="search[etime]"  placeholder="请输入结束日期"
                                value="<?php if (isset($searchvalue['etime']))echo $searchvalue['etime'];?>">
							<label for="name">查询类型：</label>:
							<select class="form-control" name="search[type]">
                                  <option value="">--查询类型--</option>
                                  <?php foreach ($recordtype as $key => $value):?>
                                  
                                  <option value="<?php echo $key?>" <?php if (isset($searchvalue['type'])&&($searchvalue['type']==$key)) echo "selected='selected'" ;?> ><?php echo $value?></option>
                              	  <?php endforeach;?>
                                </select>
						<input type="hidden" value="<?php echo $user->iid ?>" name="id">
						</div>
					</div>
					<div class="form-button">
						<button  type="submit" class="button">查询</button>
					</div>
</form>
</div>


	<table class="table table-hover">
		<caption>用户: <?php echo $user->username ?>金额记录表</caption>
		<thead>
			<tr>
			
				<th>ID</th>
			    <th>来源类型</th>
				<th>金额</th>
				<th>来源用户ID</th>
				<th>创建时间</th>
			
			</tr>
		</thead>
		<tbody>
<?php if (!empty($orders)):?>
  <?php foreach ($orders as $key => $value):?>
    <tr>
				<td><?php echo $user->iid?></td>
				<td><?php echo $recordtype[$value->type]?></td>
				<td><?php echo $value->number?></td>
				<td><?php if($value->source_user_id!=0) echo $value->source_user_id?></td>
				<td><?php echo $value->create_time?></td>
			
			
				</tr>
    <?php endforeach;?>
    <?php else: ?>
    <tr><td align="center"colspan = " 6 ">暂无记录！</td></tr>
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