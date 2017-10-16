<?php
use yii\helpers\Url;
?>

<div class="tab"> <div class="tab-head text-">

 <ul class="tab-nav">
  <li><a href="<?= Url::toRoute('setting/signsetting') ?>">签到积分设置</a> </li>
 <li><strong>会员签到列表</strong> </li>
 </ul>
  </div>
   </div>
<div class="dux-tools">
    <div class="tools-function clearfix">
            <div class="float-left">
            </div>
    </div>
</div>
  <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>会员签到列表</strong>
            <div class="button-group float-right">
   			 </div>
        </div>
        <div class="panel-body" align="center">
		<table class="table table-hover">
		<tr> <th>ID</th> <th>用户名</th> <th>签到总天数</th> <th>签到总积分</th> <th>最近签到时间</th><th>查看详情</th>
		</tr>
		 <?php foreach ($list as $key=>$vo):?>
		 <tr>
		  <td> <?php echo $vo->iid; ?></td>
		   <td> <?php echo $vo->userinfo->username; ?></td>
		      <td> <?php echo $vo->total; ?></td>
		         <td> <?php echo $vo->total_credits; ?></td>
		            <td> <?php echo date('Y-m-d',$vo->last_signtime); ?></td>
		            <th><a class="button bg-blue button-small icon-eye" href="<?= URL::to(['user/signdetails','iid'=>$vo->iid])?>" title="会员签到详情"></a></th>
		   </tr>
   <?php  endforeach; ?>



		 </table>






    </div>

</div>
<script type="text/javascript">
function signdelete(th){
	if(confirm('确定要删除该配置吗？')){
		var url=$(th).attr('url')
	        $.get(url, function(result){
			 if(result)
			 {
				 layer.msg(JSON.parse(result)['code'],{time:2000},function(){
					 location.reload();
					 });
				 }
			  });
		}
}

function signupdate(th){

		var url=$(th).attr('url')
	    parent=$(th).parent();
		var day=parent.find('input[name=day]').val();
		var credits=parent.find('input[name=credits]').val();
		var iid=parent.find('input[name=iid]').val();
		$.post(url,{
			'iid':iid,
			'credits':credits,
			'day':day
			},function(result){
				layer.msg(JSON.parse(result)['code'],{time:2000},function(){
					 location.reload();
					});

			});

}
</script>

