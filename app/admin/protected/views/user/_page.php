<?php if(!empty($pagenum) && $pagenum > 1): ?>
	<div class="panel-foot table-foot clearfix">
	   
	    <div class="float-right">
	               每页<?= $num ?>条&nbsp;&nbsp;共<?= $count ?>条
    <ul class="pagination">
    <?php if($page != 1): ?>
    	<li class="first"><a href="<?= $url ?>?page=1<?php if($find): ?>&find=1<?php endif; ?>">首页</a></li>
    	<li class="prev"><a href="<?= $url ?>?page=<?= $page-1 ?><?php if($find): ?>&find=1<?php endif; ?>">上一页</a></li>
	<?php endif; ?>
	
	<?php for(;$pagestart<=$pageend;$pagestart++): ?>
		<li<?php if($pagestart == $page): ?> class="active"<?php endif;?>><a href="<?= $url ?>?page=<?= $pagestart ?><?php if($find): ?>&find=1<?php endif; ?>"><?= $pagestart ?></a></li>
	<?php endfor; ?>
	<?php if($page != $pageend): ?>
		<li class="next"><a href="<?= $url ?>?page=<?= $page+1 ?><?php if($find): ?>&find=1<?php endif; ?>">下一页</a></li>
		<li class="last"><a href="<?= $url ?>?page=<?= $pagenum ?><?php if($find): ?>&find=1<?php endif; ?>">尾页</a></li>
	<?php endif; ?>
	</ul>
	</div> 
<?php endif;?>