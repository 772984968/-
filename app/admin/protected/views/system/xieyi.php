<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = '美影管理系统-协议设置';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-exclamation-circle" href="">协议设置</a>
		</div>
	</div>
</div>        
    <div class="admin-main">
    <?php echo html::beginForm(yii::$app->params['url']['upSystem'], 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>协议</strong>
        </div>
        <div class="panel-body">
            <div class="panel-body">
                
                <div class="form-group">
                    <div class="label"><label>标题</label></div>
                    <div class="field">
                        <?php echo $info['name'];?>  
                        <div class="input-note"></div>      
                    </div>
                </div>  
                
                <div class="form-group">
                    <div class="label"><label>内容</label></div>
                    <div class="field">
                        <?php echo Html::textarea('system[shouce]', $info['value'], ['class' => 'input js-editor','style' => 'width:500px;height:300px;']);?>
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
                    <?php echo Html::submitButton('提交', ['class' => 'button bg-main'])?>   
                    <?php echo Html::resetButton('重置', ['class' => 'button bg'])?>
                </div>
            </div>
        </div>
<?php echo html::endForm(); ?>

<script>
    Do.ready('base', function () {
        $('#form').duxFormPage();
    });

</script>
    </div>