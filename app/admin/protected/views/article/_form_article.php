<?php
use yii\helpers\Html;
?>
<?php echo html::beginForm('', 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>文章列表-><?= $title?></strong>
        </div>
        <div class="panel-body">
            <div class="panel-body">
                <div class="form-group">
                    <div class="label"><label>文章父菜单：</label></div>
                    <div class="field">
                        <?php echo Html::activeDropDownList($model, 'cat_id', $category, ['prompt' => '请选择分类','class' => 'input js-assign'], ['size' => 30]);?>
                        <div class="input-note"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label"><label>文章标题：</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'title', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?>
                        <div class="input-note"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label"><label>文章作者：</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'author', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?>
                        <div class="input-note"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label>图片</label></div>
                    <div class="field">
                        <input type="text" class="input" id="image" name="Article[article_img]" size="38" value="<?=isset($model['article_img']) ? $model['article_img'] : ''?>">
                        <a class="button bg-blue button-small  js-img-upload" data="image" id="image_upload" preview="image_preview" href="javascript:;" ><span class="icon-upload"> 上传</span></a>
                        <a class="button bg-blue button-small icon-picture-o" id="image_preview" href="javascript:;" > 预览</a>
                        <div class="input-note"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label>排序：</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'sort_order', ['class' => 'input', 'size' => 30 ,'value'=>0]);?>
                        <div class="input-note"></div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="label"><label>文章内容：</label></div>
                    <div class="field">
                        <?php echo Html::textarea('Article[content]', $model['content'], ['class' => 'input js-editor','style' => 'width:300px;height:800px;']);?>
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