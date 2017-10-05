<div class="admin-main">
	<div class="line-big">
		<div class="xm12">
			<div class="alert alert-yellow"><strong>提示：</strong>尊敬的<?php echo $admin['account'];?>，欢迎您的使用，您的本次登录时间为 <?php echo date('Y-m-d H:i:s', $admin['loginTime'])?>，登录IP为 <?php echo isset($admin['loginIp']) ? $admin['loginIp'] : '';?> </div>
		</div>
	</div>
	
</div>