<?php
use yii\helpers\Html;
?>
<?php echo html::beginForm('', 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>客户端-><?= $title?></strong>
        </div>
        <div class="panel-body">
            <div class="panel-body">
                <div class="form-group">
                    <div class="label"><label>类型</label></div>
                    <div class="field">
                           <?php echo Html::activeDropDownList($model, 'type', yii::$app->params['appInstallType'], ['prompt' => '请选择分类','class' => 'input js-assign'], ['size' => 30]);?>
                        <div class="input-note"></div>  
                    </div>  
                </div>
                <div class="form-group">
                    <div class="label"><label>版本号</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'version', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?>  
                        <div class="input-note"></div>      
                    </div>
                </div>  
                <div class="form-group">
                    <div class="label"><label>升级地址</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'remove', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?> 
                        <div class="input-note"></div>
                    </div>  
                </div>
                <div class="form-group">
                    <div class="label"><label>备注</label></div>
                    <div class="field">
                        <?php echo Html::textarea('App[remark]', $model['remark'], ['class' => 'input js-editor','style' => 'width:500px;height:300px;']);?>
                        <div class="input-note"></div>                      
                    </div>                          
                </div>
                <div class="form-group">
                    <div class="label"><label>状态</label></div>
                    <div class="button-group button-group-small radio">
                        <label class="button <?php if($model['status'] == 1) echo  'active' ?>"><input name="App[status]" value="1" <?php if($model['status'] == 1) echo  'checked="checked"' ?>  type="radio">
                        <span class="icon icon-check"></span>启用</label>
                        <label class="button <?php if($model['status'] == 0) echo  'active' ?>"><input name="App[status]" value="0" <?php if($model['status'] == 0) echo  'checked="checked"' ?> type="radio">
                        <span class="icon icon-check"></span>禁用</label>
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
    </div>
<?php echo html::endForm();?>
<script>
    Do.ready('base', function () {
        $('#form').duxFormPage();
    });

</script>