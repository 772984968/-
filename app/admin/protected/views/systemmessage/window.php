<?php
use yii\helpers\Url;
$this->title = '';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['systemmessage']);?>">系统信息</a>
        </div>
    </div>
</div>
<div class="admin-main">
    <?php echo $this->render('_form', ['title' => '添加', 'model' => $model]); ?>
</div>
    