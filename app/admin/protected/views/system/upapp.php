<?php
use yii\helpers\Url;
$this->title = '美影管理系统-修改客户端';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['app']);?>">客户端</a>
        </div>
    </div>
</div>
<div class="admin-main">
    <?php echo $this->render('_app_form', ['title' => '修改', 'model' => $model]); ?>
</div>
    