<?php
use yii\helpers\Html;
?>
<?php echo html::beginForm('', 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>广告-><?= $title?></strong>
        </div>
        <div class="panel-body">
            <div class="panel-body">
                <div class="form-group">
                    <div class="label"><label>类型</label></div>
                    <div class="field">
					 <select name="Ads[type]" id="type" class="input" datatype="*">
                            <option value="0">==请选择==</option>
                            <?php foreach ($adstype as $k => $v):?>
                            <option  <?php if (isset($model['type']) && $model['type'] == $k)  echo "selected"?> value="<?php echo isset($k) ? $k : '';?>">
                            <?php echo isset($v) ? $v : '';?>
                            </option>
                            <?php endforeach;?>
                            </select>
                        <div class="input-note"></div>  
                    </div>  
                </div>
                <div class="form-group">
                    <div class="label"><label>名称</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'name', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?>  
                        <div class="input-note"></div>      
                    </div>
                </div>  
                <div class="form-group">
                    <div class="label"><label>图片</label></div>
                    <div class="field">
                        <input type="text" class="input" id="image" name="Ads[image]" size="38" value="<?=isset($model['image']) ? $model['image'] : ''?>">
                        <a class="button bg-blue button-small  js-img-upload" data="image" id="image_upload" preview="image_preview" href="javascript:;" ><span class="icon-upload"> 上传</span></a>
                        <a class="button bg-blue button-small icon-picture-o" id="image_preview" href="javascript:;" > 预览</a>
                        <div class="input-note"></div>
                    </div>  
                </div>
                <div class="form-group">
                    <div class="label"><label>链接ID</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'url', ['class' => 'input', 'size' => 30]);?>
                        <div class="input-note"></div>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="label"><label>排序</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'listorder', ['class' => 'input', 'size' => 30]);?>
                        <div class="input-note"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label"><label>额外参数</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'parameter', ['class' => 'input', 'size' => 30]);?>
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
    </div>
<?php echo html::endForm();?>
<script>
    Do.ready('base', function () {
        $('#form').duxFormPage();
    });

</script>