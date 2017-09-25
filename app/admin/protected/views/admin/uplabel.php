<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '美影管理系统-编辑标签管理';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-back icon-list" href="javascript:;">修改用户类型权限</a>
        </div>
    </div>
</div>

<div class="admin-main">
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>修改用户类型权限</strong>
        </div>
        <?php echo html::beginForm('', 'Post', ['class' => 'form-x dux-form form-auto', 'id'=>'form1']); ?>
        <div class="panel-body">
            <div class="form-group">
                <div class="label"><label>用户类型名称：</label></div>
                <div class="field">
                    <input type="text" class="input" datatype="*" errormsg="" disabled="true" value="<?php echo $name?>">
                    <input type="hidden" value="<?php echo $id;?>" name="id">
                    <div class="input-note"></div>  
                </div>  
            </div>
           <div class="form-group" style="height:auto;">
                <div class="label "><label>发布权限：</label></div>  
                <div class="field">
                   <table id="table" class="table table-hover table-bordered">
                        <tbody>
                            <tr class="root_div">
                                <td width="100">
                                    <input id="inlineCheckbox1" checked="checked" hidden="" type="checkbox"> 
                                    &nbsp; <b>价格类型</b>
                                </td>
                                <td class="son_div">
                                    <input id="inlineCheckbox1" checked="checked" hidden="" type="checkbox">&nbsp;可发布价格列表
                                </td>
                            </tr>

                            <tr class="root_div">
                                <td width="100" class="son_div">
                                    <input id="inlineCheckbox1" type="checkbox" name="push" value="4" <?php if(isset($access[4])){echo "checked='checked'";}?>> 
                                    &nbsp; <b>价格类型</b>
                                </td>
                                <td class="son_div">
                                    <span>
                                        <input id="inlineCheckbox1" name="pushid[]" value="0" type="checkbox" <?php if(isset($access[4]) && in_array('0',$access[4])){echo "checked='checked'";}?>>&nbsp;批发价
                                    </span>
                                    <span>
                                        <input id="inlineCheckbox1" name="pushid[]" value="1" type="checkbox" <?php if(isset($access[4]) && in_array('1',$access[4])){echo "checked='checked'";}?>>&nbsp;销售价
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                     </table>    
                </div>
            </div>
			<div class="form-group" style="height:auto;">
				<div class="label "><label>访问权限：</label></div>  
				<div class="field">
                   <table id="table" class="table table-hover table-bordered">
                        <tbody>
                            <tr class="root_div">
                                <td width="100">
                                    <input id="inlineCheckbox1" checked="checked" hidden="" type="checkbox"> 
                                    &nbsp; <b>访问类型</b>
                                </td>
                                <td class="son_div">
                                    <input id="inlineCheckbox1" checked="checked" hidden="" type="checkbox">&nbsp;可访问用户列表
                                </td>
                            </tr>

                            <tr class="root_div">
                                <td width="100" class="son_div">
                                    <input id="inlineCheckbox1" name="powerp" value="0" type="checkbox" <?php if(isset($access[0])){echo "checked='checked'";}?>> 
                                    &nbsp; <b>批发价</b>
                                </td>
                                <td class="son_div">
                                    <?php if(isset($userdata)):?>
                                        <?php foreach($userdata as $v):?>
                                            <span>
                                                <input id="inlineCheckbox1" name="powerpid[]" value="<?php echo $v['id'];?>" type="checkbox" <?php if(isset($access[0]) && in_array($v['id'],$access[0])){echo "checked='checked'";}?>>&nbsp;<?php echo $v['name'];?>
                                            </span>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </td>
                            </tr>

                             <tr class="root_div">
                                <td width="100" class="son_div">
                                    <input id="inlineCheckbox1" name="power" value="1" type="checkbox" <?php if(isset($access[1])){echo "checked='checked'";}?>> 
                                    &nbsp; <b>价格</b>
                                </td>
                                <td class="son_div">
                                   <?php if(isset($userdata)):?>
                                        <?php foreach($userdata as $v):?>
                                            <span>
                                                <input id="inlineCheckbox1" name="powerid[]" value="<?php echo $v['id'];?>" type="checkbox" <?php if(isset($access[1]) && in_array($v['id'],$access[1])){echo "checked='checked'";}?>>&nbsp;<?php echo $v['name'];?>
                                            </span>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </td>
                            </tr>
                        </tbody>
                     </table>    
                </div>
			</div>
            <div class="form-group" style="height:auto;">
                <div class="label "><label>购买权限：</label></div>  
                <div class="field">
                   <table id="table" class="table table-hover table-bordered">
                        <tbody>
                            <tr class="root_div">
                                <td width="100">
                                    <input id="inlineCheckbox1" checked="checked" hidden="" type="checkbox"> 
                                    &nbsp; <b>购买价格</b>
                                </td>
                                <td class="son_div">
                                    <input id="inlineCheckbox1" checked="checked" hidden="" type="checkbox">&nbsp;可购买用户列表
                                </td>
                            </tr>

                            <tr class="root_div">
                                <td width="100" class="son_div">
                                    <input id="inlineCheckbox1" name="buyp" value="2" type="checkbox" <?php if(isset($access[2])){echo "checked='checked'";}?>> 
                                    &nbsp; <b>批发价</b>
                                </td>
                                <td class="son_div">
                                    <?php if(isset($userdata)):?>
                                        <?php foreach($userdata as $v):?>
                                            <span>
                                                <input id="inlineCheckbox1" name="buypid[]" value="<?php echo $v['id'];?>" type="checkbox" <?php if(isset($access[2]) && in_array($v['id'],$access[2])){echo "checked='checked'";}?>>&nbsp;<?php echo $v['name'];?>
                                            </span>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </td>
                            </tr>

                             <tr class="root_div">
                                <td width="100" class="son_div">
                                    <input id="inlineCheckbox1" name="buy" value="3" type="checkbox" <?php if(isset($access[3])){echo "checked='checked'";}?>> 
                                    &nbsp; <b>销售价</b>
                                </td>
                                <td class="son_div">
                                   <?php if(isset($userdata)):?>
                                        <?php foreach($userdata as $v):?>
                                            <span>
                                                <input id="inlineCheckbox1" name="buyid[]" value="<?php echo $v['id'];?>" type="checkbox" <?php if(isset($access[3]) && in_array($v['id'],$access[3])){echo "checked='checked'";}?>>&nbsp;<?php echo $v['name'];?>
                                            </span>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </td>
                            </tr>
                        </tbody>
                     </table>    
                </div>
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
    $(":input[name='power']").click(function(){
        var _check = $(this).attr("checked");
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
        var f_chk_box = $(this).parents(".root_div").find('.son_div').find(":input[name='power']");
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
    $(":input[name='powerp']").click(function(){
        var _check = $(this).attr("checked");
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
    $(":input[name='powerpid[]']").click(function(){
        var chk_box = $(this).parents(".son_div").find("input");
        var f_chk_box = $(this).parents(".root_div").find('.son_div').find(":input[name='powerp']");
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