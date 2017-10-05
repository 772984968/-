<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '美影管理系统-添加管理员角色组';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-back icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['upRole']);?>">修改角色组</a>
        </div>
    </div>
</div>

<div class="admin-main">
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>修改角色组</strong>
        </div>
        <?php echo html::beginForm(Url::toRoute(yii::$app->params['url']['upRole']).'?id='.$model['id'], 'Post', ['class' => 'form-x dux-form form-auto', 'id'=>'form']); ?>
        <div class="panel-body">
            <div class="form-group">
                <div class="label"><label>角色组名称：</label></div>
                <div class="field">
                    <input type="text" class="input" id="roleName" name="roleName" datatype="*" errormsg="" value="<?php echo $model['group_name']; ?>">
                    <div class="input-note"></div>  
                </div>  
            </div>
			<div class="form-group" style="height:auto;">
				<div class="label "><label>角色权限：</label></div>  
				<div class="field"><?php echo $menu;?></div>
			</div>
        </div>
        <div class="panel-foot">
            <div class="form-button">
                <div id="tips">
                <?php  if (isset($error)) {?>
                    <div class="alert alert-yellow">
                        <strong>注意：</strong>
                        <?php echo $error; ?>
                    </div>   
                <?php }?>         
                </div>
                <button class="button bg-main" type="submit">保存</button>
                <button class="button bg" type="reset">重置</button>
            </div>
        </div>
        <?php echo html::endForm(); ?>
    </div>
</div>
<script type="text/javascript">
$(function(){
    $(":input[name='power[]']").click(function(){
        var _check = $(this).attr("checked");
        //console.log(_check);
        var chk_box = $(this).parents(".root_div").find('.son_div').find("input");
        if (_check == "checked") {
            chk_box.each(function(i){ 
                $(this).attr("checked", true);
            });
        } else {
            chk_box.each(function(i){ 
                $(this).attr("checked", false);
            });
        }
    });
    $(":input[name='powerid[]']").click(function(){
        var chk_box = $(this).parents(".son_div").find("input");
        var f_chk_box = $(this).parents(".root_div").find('.son_div').find(":input[name='power[]']");
        var _chklen = 0;
        chk_box.each(function(i){ 
            if ($(this).attr("checked")) {
                _chklen ++;
            }
        });
        
        if (_chklen > 0){
            f_chk_box.attr("checked", true);
        } else {
            f_chk_box.attr("checked", false);
        }
    });
});


Do.ready('base', function () {
    $('#form').duxFormPage();
});

</script>