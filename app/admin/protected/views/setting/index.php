<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $other['title'];
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <?php if(!empty($other['menuname'])):  ?>
            <div class="float-left">
                <a class="button button-small bg-main icon-exclamation-circle" href="<?= $other['menuurl'] ?>"><?= $other['menuname'] ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>
    <div class="admin-main">
    <?php echo html::beginForm(yii::$app->params['url']['upSetting'], 'Post', array('id' => 'form', 'class' => 'form-x dux-form form-auto'));?>
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong><?= $other['formname'] ?></strong>
        </div>
        <div class="panel-body">

         <?php echo $this->render('_form', ['data' => $data, 'other' => $other]); ?>
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