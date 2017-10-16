<?php
use yii\helpers\Html;
?>
<script type="text/javascript" src="/style/js/Area.js"></script>
<script type="text/javascript" src="/style/js/AreaData_min.js"></script>
        <div class="collapse">
              <div class="panel active">
                <div class="panel-head"><h4><!--title--></h4></div>
                <div class="panel-body">
                    <?php $timeinput = [] ?>
                    <?php foreach( $fieldOption as $field ): ?>
                        <div class='form-group'>
                            <div class='label'><label><?= Yii::t('common',$field['key']) ?></label></div>
                            <div class='field'>
                                <?php $fileName = $config['modelShortName'].'['.$field['key'].']' ?>
                                <?php switch($field['html']): ?><?php case 'image': ?>
                                        <input type='text' class='input' id='<?= $field['key'] ?>'name='<?= $fileName ?>' size='38' value='<?= Html::encode($field['value']) ?>'>
                                        <a class='button bg-blue button-small  js-img-upload' data='<?= $field['key'] ?>' id='<?= $field['key'] ?>_upload' preview='<?= $field['key'] ?>_preview' href='javascript:;' >
                                        <input type="hidden" value="500" class="input" id="height" >
                                        <input type="hidden" value="500" class="input" id="width">
                                        <input type="hidden" value="exact" name="model">自动裁剪500*500
                                        <span class='icon-upload'> 上传</span>
                                        </a>
                                        <a class='button bg-blue button-small icon-picture-o' id='<?= $field['key'] ?>_preview' href='javascript:;' > 预览</a>
                                        <div class='input-note'></div>
                                    <?php break; ?>

                                    <?php case 'images': ?>
                                        <input type='text' class='input' id='<?= $field['key'] ?>'name='<?= $fileName ?>' size='38' value='<?= Html::encode($field['value']) ?>'>
                                        <a class='button bg-blue button-small  js-multi-upload' data='<?= $field['key'] ?>' id='<?= $field['key'] ?>_upload' preview='<?= $field['key'] ?>_preview' href='javascript:;' >
                                            <span class='icon-upload' data="uploadimages"> 上传</span>
                                        </a>
                                        <div id="uploadimages"></div>
                                        <div class='input-note'></div>
                                    <?php break; ?>

                                    <?php case 'file': ?>
                                    <input type='text' class='input' id='<?= $field['key'] ?>'name='<?= $fileName ?>' size='38' value='<?= Html::encode($field['value']) ?>'>
                                    <a class='button bg-blue button-small  js-file-upload' data='<?= $field['key'] ?>' id='<?= $field['key'] ?>_upload' preview='<?= $field['key'] ?>_preview' href='javascript:;' >
                                        <span class='icon-upload'> 上传</span>
                                    </a>
                                    <div class='input-note'></div>

                                    <?php break; ?>

                                    <?php case 'textarea': ?>
                                        <textarea name='<?= $fileName ?>'  class='input' cols='60' rols='6'><?= Html::encode($field['value']) ?></textarea>
                                    <?php break; ?>

                                    <?php case 'texts': ?>
                                        <textarea class="input js-editor" style="width:300px;height:400px;" name="<?= $fileName ?>">
                                            <?= $field['value'] ?>
                                        </textarea>
                                    <?php break; ?>

                                    <?php case 'time': ?>
                                        <?= Html::textInput($fileName,$field['value'], ['class' => 'input', 'size' => 25, 'id' => $field['key'], 'placeholder' => Yii::t('common',$field['key']) ]); ?>
                                        <?php $timeinput[] = $field['key'] ?>
                                    <?php break; ?>

                                    <?php case 'radio': ?>
                                        <?= Html::radioList($fileName, !isset($field['value']) ? array_keys($field['option'])[0] : $field['value'], $field['option']); ?>
                                    <?php break; ?>

                                    <?php case 'select': ?>
                                        <?= Html::dropDownList($fileName, $field['value'],$field['option'],['class' => 'input','style'=>'min-width:400px;','id'=>$field['key']]); ?>
                                    <?php break; ?>

                                    <?php case 'checkbox': ?>
                                        <?= Html::checkbox($fileName, $field['value'],$field['option'],['class' => 'input','style'=>'min-width:400px;','id'=>$field['key']]); ?>
                                    <?php break; ?>

                                    <?php case 'password': ?>
                                        <input name='<?= $fileName ?>' type='password' class='input' size='60' value='<?= Html::encode($field['value']) ?>' <?php if($config['method'] != 'change' && !isset($field['update']) && !empty($field['datatype'])): ?> datatype="<?= $field['datatype'] ?? '' ?> <?php endif; ?> />
                                    <?php break; ?>

                                    <?php default: ?>
                                        <input name='<?= $fileName ?>' type='text' class='input' size='60' value='<?= Html::encode($field['value']) ?>' <?php if($config['method'] != 'change' && !isset($field['update']) && !empty($field['datatype'])): ?> datatype="<?= $field['datatype'] ?? '' ?>" <?php endif; ?> <?php if(isset($field['changedisabled']) && $config['method'] == 'change'):?> disabled="disabled" <?php endif;?> />
                                        <?php if ($fileName=='User[nickname]'): ?>
                                       <button class="button bg" type="button"  onclick="refresh();"><span class="icon-refresh"></span></button>
                                        <?php endif;?>
                                         <?php if ($fileName=='User[username]'): ?>
                                       <button class="button bg" type="button"  onclick="refreshName();"><span class="icon-refresh"></span></button>
                                        <?php endif;?>

                                    <?php break; ?>

                                <?php endswitch; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if(isset($config['primaryKey'])): ?>
                        <input style="display: none" type="text" name="<?= $config['modelShortName'] ?>[<?= $config['primaryKey'] ?>]" value="<?= $config['primaryKeyValue'] ?>"
                    <?php endif; ?>
                </div>
              </div>
        </div>
<script type="text/javascript">
 function refresh(){
	 var name=['李_','宝宝','王强','张','郑','刘','最强','上官','司徒__','欧阳__','_轩辕'];
		var ming=["彪_","巨昆","锐_","翠花","小小","撒撒","熊大","宝强",'哒','A','bc','bb','pp','_sb','_wo','王者','民','明','林'];
		var xing = name[Math.floor(Math.random() * (name.length))];
		var ming = ming[Math.floor(Math.random() * (ming.length))];
		var name=xing+ming;
		$("input[name='User[nickname]']").attr('value',name);
		}

</script>

<script type="text/javascript">
 function refreshName(){
	   var name=['136','181','189','158','137','159','150','138','159'];
		var xing = name[Math.floor(Math.random() * (name.length))];
		var ming = Math.ceil(Math.random() * 100000000+100000000);
		var name=xing+ming;
		$("input[name='User[username]']").attr('value',name);
		}

</script>

<script>
    Do.ready('base', function () {
        $('#form').duxFormPage();
        <?php foreach( $timeinput as $fieldName):?>
            $('#<?= $fieldName ?>').duxTime();
        <?php endforeach;?>
    });
</script>