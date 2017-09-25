<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '美影管理系统-支付设置';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-exclamation-circle" href="">支付设置</a>
		</div>
	</div>
</div>        
    <div class="admin-main">
    <?php echo html::beginForm(yii::$app->params['url']['upSystem'], 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>支付设置</strong>
        </div>
        <div class="panel-body">
        <?php if(!empty($data)): ?>
        	<?php foreach($data as $k => $v): ?>
            <div class="form-group">
                <div class="label">
                    <label for="sitename"><?= isset($v['name']) ? $v['name']:'';?></label>
                </div>
                <div class="field">
                    <input type="text" class="input" id="site_title" name="system[<?= isset($v['key']) ? $v['key']:'';?>]" size="60" value="<?= isset($v['value']) ? $v['value']:'';?>" datatype="*">
                    <div class="input-note"></div>
                </div>
            </div>
            	<?php endforeach; ?>
            <?php endif; ?>
       
        <div class="panel-foot">
            <div class="form-button">
                <div id="tips"></div>
                <button class="button bg-main" type="submit">保存</button>
                <button class="button bg" type="reset">重置</button>
            </div>
        </div>
    </div>
<?php echo html::endForm(); ?>
<script>
    Do.ready('base', function () {
        $('#form').duxForm();
    });
</script>

    </div>