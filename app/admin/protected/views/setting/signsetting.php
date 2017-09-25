<?php
use yii\helpers\Url;
?>

<div class="tab"> <div class="tab-head text-">
 <ul class="tab-nav">
  <li> <strong>签到积分设置</strong></li>
 <li>  <a href="<?= Url::toRoute('user/sign') ?>">会员签到列表</a></li>
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
            <strong>积分签到设置</strong>
            <div class="button-group float-right">
   			 <a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?= Url::toRoute('signadd') ?>"> 添加天数</a>
   			 </div>
        </div>
        <div class="panel-body" align="center">
        <form action="<?= Url::toRoute('signupdate')?>" class="dux-form form-auto" method="post">
        <div class="panel-foot">
            <div class="form-button">
				<label class="label"> 签到天数-奖励积分值</label>
				<?php foreach ($signsetting as $key=>$vo):?>
				<?php if ($vo->continue_day==0): ?>
				<div id="div">
				<input type="hidden" class="input"  value="<?= $vo->iid?>" name="iid"/>
				<input type="text" placeholder="签到天数" class="input"  value="<?= $vo->sign_day?>" name="day"/>
				<input type="text" placeholder="奖励经验值" class="input" value="<?= $vo->credits ?>" name="credits"/>
				&nbsp;	&nbsp;	&nbsp;
     			<a class="button bg-blue button-small icon-pencil"onclick="signupdate(this);" url="<?=  Url::to(['signupdate']) ?>" title="修改"></a>
				<a class="button bg-red button-small icon-trash-o js-del"onclick="signdelete(this);" url="<?=  Url::to(['signupdate','iid'=>$vo->iid]) ?>" title="删除"></a>
			    </div>
				<br>
				<?php else:?>
				<div id="div">
					<label class="label"> 持续签到天数-奖励积分</label>
				<input type="hidden" class="input"  value="<?= $vo->iid?>" name="iid"/>
				<input type="text" placeholder="签到天数" class="input"  value="<?= $vo->sign_day?>" name="day"/>
				<input type="text" placeholder="奖励经验值" class="input" value="<?= $vo->credits ?>" name="credits"/>
				&nbsp;	&nbsp;	&nbsp;
				<a class="button bg-blue button-small icon-pencil"onclick="signupdate(this);" url="<?=  Url::to(['signupdate']) ?>" title="修改"></a>
                &nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;

				<br><br>
				</div>
				<?php endif; ?>
				<?php endforeach; ?>
            </div>
        </div>
            </form>
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

