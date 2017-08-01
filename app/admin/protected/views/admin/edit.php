<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = '修改管理员';
?>
<div class="admin-main">
		<?php 
			/*$form = ActiveForm::begin([
			'action' => ['/sadmin/add'],
			'method'=>'post',
			'id' => 'form',
			'options' => ['class' => 'form-x dux-form form-auto'],
		 ]);*/ ?>
	
	<?php echo html::beginForm('' , 'Post', array('id' =>'form','class' => 'form-x dux-form form-auto'));?>
	<div class="panel dux-box  active">
		<div class="panel-head">
			<strong>管理员列表->修改管理员</strong>
		</div>
		<div class="panel-body">

			<div class="panel-body">
				<div class="form-group">
					<div class="label"><label>所属权限组</label></div>
					<div class="field">
						<?php if(isset($model->group->is_admin) && $model->group->is_admin != 1): ?>
						<?php echo Html::activeDropDownList($model, 'group_id', $power, ['prompt' => '请选择分类','class' => 'input js-assign']);?>
						<?php else: ?>
						<?php echo html::textInput('group_id', '超级管理员', ['class' => 'input', 'disabled' => 'disabled']); ?>
					    <?php endif; ?>
						<div class="input-note"></div>	
					</div>	
				</div>
				<div class="form-group">
					<div class="label"><label>登录账号</label></div>
					<div class="field">
						<?php echo Html::activeTextInput($model, 'account',['class'=>'input','size'=>30]);?>
						<?php echo Html::error($model, 'account');?>				
					</div>
				</div>	
				<div class="form-group">
					<div class="label"><label>登录密码</label></div>
					<div class="field">
						<input type="password" class="input" name="Admin[pass]" size="30"  value="">
						<div class="input-note"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="label"><label>管理员昵称</label></div>
					<div class="field">
						<?php echo Html::activeTextInput($model, 'nickname',['class'=>'input','size'=>30]);?>
						<div class="input-note"></div>
					</div>	
				</div>
				<div class="form-group">
					<div class="label"><label>Email</label></div>
					<div class="field">
						<?php echo Html::activeTextInput($model, 'email',['class'=>'input','size'=>30]);?>
						<div class="input-note"></div>						
					</div>							
				</div>
				<div class="form-group">
					<div class="label"><label>联系电话</label></div>
					<div class="field">
						<?php echo Html::activeTextInput($model, 'phone',['class'=>'input','size'=>30]);?>
						<div class="input-note"></div>							
					</div>						
				</div>
				<div class="form-group">
						<div class="label"><label>是否可用</label></div>
						<div class="field">
						<div class="button-group button-group-small radio">
	                        <label class="button <?php if($model['state'] == 1) echo 'active';?>"><input name="Admin[state]" value="1" <?php if($model['state'] == 1) echo 'checked="checked"';?> type="radio">
	                        <span class="icon icon-check"></span> 可用</label>
	                        <label class="button <?php if($model['state'] == 0) echo 'active';?>"><input name="Admin[state]" value="0" type="radio" <?php if($model['state'] == 0) echo 'checked="checked"';?>>
	                        <span class="icon icon-times"></span> 不可用</label>
	                    </div>
							<div class="input-note"></div>							
						</div>
				</div>

			</div>
			<div class="panel-foot">
				<div class="form-button">
					<div id="tips"></div>
					<?php echo Html::activeHiddenInput($model, 'id');?>
					<?php echo Html::submitButton('修改', ['class'=>'button bg-main']) ?>   
					<?php echo Html::resetButton('重置', ['class'=>'button bg']) ?>
				</div>
			</div>
		<?php echo html::endForm(); ?>
		</div>
	</div>
</div>
<script>
    Do.ready('base', function () {
        $('#form').duxFormPage();
    });

</script>   