<?php
use yii\helpers\Html;
?>
<?php echo html::beginForm('', 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>热门活动-></strong>
        </div>
        <div class="panel-body">
            <div class="panel-body">

                <div class="form-group">
                    <div class="label"><label>标题</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'title', ['class' => 'input', 'size' => 30]);?>
                        <div class="input-note"></div>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="label"><label>文本</label></div>
                    <div class="field">
                        <textarea name="SystemMessage[content]" class="input" cols="100" rows="10">
                            <?= $model->content ?>
                        </textarea>
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