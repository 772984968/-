<?php
use yii\helpers\Url;
$this->title = '福布斯管理系统-发布文章';
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left">
			<a class="button button-small bg-main icon-list" href="<?php echo Url::toRoute(yii::$app->params['url']['articlelist']);?>">文章列表</a>
		</div>
	</div>
</div>
<div class="admin-main">
	<?php echo $this->render('_form_article', ['title' => '发布', 'model' => $model, 'category' => $category]); ?>
</div>
