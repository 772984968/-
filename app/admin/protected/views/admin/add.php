<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '美影管理系统-添加管理员';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['admin']);?>">管理员列表</a>
		</div>
	</div>
</div>
<div class="admin-main">
	<?php echo html::beginForm('', 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
	<div class="panel dux-box  active">
		<div class="panel-head">
			<strong>管理员列表->添加管理员</strong>
		</div>
		<div class="panel-body">
			<div class="panel-body">
				<div class="form-group">
					<div class="label"><label>所属权限组</label></div>
					<div class="field">
						<?php echo Html::activeDropDownList($model, 'group_id', $power, ['prompt' => '请选择分类','class' => 'input js-assign'], ['size' => 30]);?>
						<div class="input-note"></div>	
					</div>	
				</div>
				<div class="form-group">
					<div class="label"><label>登录账号</label></div>
					<div class="field">
						<?php echo Html::activeTextInput($model, 'account', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?>		
					</div>
				</div>	
				<div class="form-group">
					<div class="label"><label>登录密码</label></div>
					<div class="field">
						<?php echo Html::activePasswordInput($model, 'pass', ['class' => 'input', 'size' => 30]);?>
						<div class="input-note"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="label"><label>管理员昵称</label></div>
					<div class="field">
						<?php echo Html::activeTextInput($model, 'nickname', ['class' => 'input', 'size' => 30]);?>
						<div class="input-note"></div>
					</div>	
				</div>
				<div class="form-group">
					<div class="label"><label>Email</label></div>
					<div class="field">
						<?php echo Html::activeTextInput($model, 'email', ['class' => 'input', 'size' => 30]);?>
						<div class="input-note"></div>						
					</div>							
				</div>
				<div class="form-group">
					<div class="label"><label>联系电话</label></div>
					<div class="field">
						<?php echo Html::activeTextInput($model, 'phone', ['class' => 'input', 'size' => 30]);?>
						<div class="input-note"></div>							
					</div>						
				</div>
				<div class="form-group">
					<div class="label"><label>是否可用</label></div>
					<div class="button-group button-group-small radio">
						<label class="button active"><input name="Admin[state]" value="1" checked="checked" type="radio">
						<span class="icon icon-check"></span> 可用</label>
						<label class="button"><input name="Admin[state]" value="0" type="radio">
						<span class="icon icon-times"></span> 不可用</label>
					</div>
					<div class="field">
						<?php //echo Html::activeRadioList($model, 'state', [0 => '不可用', 1 => '可用'], ['class' => 'input', 'size' => 30]);?>
						<div class="input-note"></div>							
					</div>
				</div>
			</div>
			<div class="panel-foot">
				<div class="form-button">
					<div id="tips">
						<?php if(isset($error)) :?>
							<div class="alert alert-yellow">
								<strong>注意：</strong>
							<?php echo $error;?>
							</div>   
						<?php endif;?>  
					</div>
					<?php echo Html::submitButton('添加', ['class' => 'button bg-main'])?>   
					<?php echo Html::resetButton('重置', ['class' => 'button bg'])?>
				</div>
			</div>
			<?php echo html::endForm();?>
		</div>
	</div>
</div>
<script>
	Do.ready('base', function () {
		$('#form').duxFormPage();
	});

</script>	