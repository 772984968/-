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
	 var name=['李','宝宝','王强','张','郑','刘','张','上官','司徒','欧阳','轩辕',
		 '赵','钱','孙','周','吴','郑','','孔','曹' ,'严',
		 '华','金','魏','陶','姜','戚' ,'谢','邹','喻',
		 '柏','水', '窦' ,'章', '云' ,'苏', '潘' ,'葛', '奚' ,'范 ','郎',
		 '鲁','韦', '昌' ,'马', '凤', '花', '方','俞', '任', '袁' ,'柳',
		 '酆','鲍', '史' ,'唐', '费', '廉' ,'岑' ,'薛', '雷' ,'贺', '倪', '汤',
		 '滕','殷','罗', '毕' ,'郝' ,'邬', '安', '常', '乐', '于' ,'时', '傅',
		 '皮','卞', '齐', '康', '伍' ,'余' ,'元','卜', '顾' ,'孟', '平','黄',
		 '和','穆 ','萧' ,'尹' ,'姚', '邵', '湛' ,'汪' ,'祁', '毛', '禹','狄'];
		var ming=["彪_","巨昆_","锐_","翠花","小小","撒撒","熊大","宝强",'哒','AA','bc','baobao','pp','_wo',
			'王者','民','明','林','子涵','欣怡','梓涵','晨曦','紫涵','诗涵','梦琪','嘉怡','子萱','雨涵','子轩',
			'浩宇','浩然_','博文' ,'宇轩_' ,'子涵_','雨泽','皓轩','浩轩_' ,'梓轩_',
			'英','梅','华','兰珍','芳','伟','军','丽' ,'敏','荣','勇',
			'静'	,'燕','娟','婷','强','云_',	'杰','平','超_','艳','磊','丹_',
			'玲','明','峰','浩','飞','辉','鑫_','鹏',
			'颖','洋','国','刚','莉',
			];
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