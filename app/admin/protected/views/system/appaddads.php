<?php
use yii\helpers\Url;
$this->title = '卡客管理系统-添加广告';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['ads']);?>">广告管理</a>
        </div>
    </div>
</div>
<div class="admin-main">
    <?php echo $this->render('_appad_form', ['title' => '添加', 'model' => $model,'adstype'=>$adstype]); ?>
</div>
    