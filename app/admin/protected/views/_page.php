<?php
use yii\widgets\LinkPager;
?>
<div class="float-right">
                每页<?php echo \yii::$app->params['pageSize'];?>条&nbsp;&nbsp;共<?php echo $count; ?>条
                <?php echo LinkPager::widget(['pagination' => isset($page) ? $page : '', 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页','firstPageLabel' => '首页', 'lastPageLabel'=>'尾页']);?>
</div>