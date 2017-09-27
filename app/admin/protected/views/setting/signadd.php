<?php
use yii\helpers\Url;
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
            <div class="float-left">
            </div>
    </div>
</div>
  <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>积分签到设置</strong>
        </div>
        	<button class="button win-back icon-arrow-left"  type="button" onclick="javascript:history.back(-1);">返回</button>
        <div class="panel-body" align="center">
        <form action="<?= Url::toRoute('signadd')?>" class="dux-form form-auto"  method="post">
        <div class="panel-foot">
            <div class="form-button">
				<label class="label"> 签到天数--奖励积分值</label>
				<input type="number" placeholder="签到天数" class="input" min="0" name="day" />
				<input type="number" placeholder="奖励经验值" class="input" name="credits" min="0" /><br>
				<br><br>
               <button class="button bg-main" type="submit">添加</button>
                <button class="button bg" type="reset">重置</button>
            </div>
        </div>
            </form>
    </div>

</div>