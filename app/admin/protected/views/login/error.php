<?php
use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
	<h1><?php echo Html::encode($message->statusCode.$message->getMessage());?></h1>
	<div class="alert alert-danger message">
		<?php echo nl2br(Html::encode($message));?>
	</div>
</div>