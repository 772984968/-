<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $config['listTitle'];

?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <?php if(!empty($config['listTitle'])):  ?>
            <div class="float-left">
                <a class="button button-small bg-main icon-exclamation-circle" href="<?php echo Url::toRoute(yii::$app->params['url'][$config['listUrl']]);?>"><?= $config['listTitle'] ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>        
    <div class="admin-main">
    <?php echo html::beginForm('', 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto','enctype'=>'multipart/form-data'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong><!--title--></strong>
        </div>
        <div class="panel-body">

         <?php echo $this->render('_form', ['fieldOption' => $fieldOption, 'config' => $config, 'menu'=>$menu]); ?>
       
        <div class="panel-foot">
            <div class="form-button">
                <div id="tips"></div>
                <button class="button bg-main" type="submit">保存</button>
                <button class="button bg" type="reset">重置</button>
            </div>
        </div>

    </div>
<?php echo html::endForm(); ?>


    </div>