<?php
use yii\helpers\Url;
?>

<div class="tab"> <div class="tab-head text-">
<button class="button win-back icon-arrow-left" type="button">返回</button>
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
            <strong>会员签到详情</strong>
            <div class="button-group float-right">
   			 </div>
        </div>
        <div class="panel-body" align="center">
		<table class="table table-hover">
		<tr> <th>ID</th><th>签到年-月</th> <th>本月签到天数</th><th>本月累计签到天数</th>
		</tr>
		 <?php foreach ($list as $key=>$vo):?>
		 <tr>
		  <td> <?=  $vo->iid; ?></td>
		   <td> <?=  $vo->year.'-'.$vo->month ?></td>
		        <td> <?= $vo->day; ?></td>
		         <td> <?= $vo->total_mon; ?></td>

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

