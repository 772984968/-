<?php
use yii\helpers\Url;
?>
<div class="dux-tools">
	<div class="tools-function clearfix">
		<div class="float-left"></div>
	</div>
</div>
<div class="panel dux-box  active">
	<div class="panel-head">
		<strong>添加群发消息</strong>
	</div>
	<button class="button win-back icon-arrow-left" type="button"
		onclick="javascript:history.back(-1);">返回</button>
	<form method="post" class="form-x form-auto">
		<div class="form-group">
			<div class="label">
				<label for="username"> 标题</label>
			</div>
			<div class="field">
				<input type="text" class="input input-auto input-big" id="username"
					name="title" size="100" placeholder="请输入标题" />
			</div>

		</div>
		<br><br>
		<div class="form-group">
			<div class="label">
				<label for="password"> 内容</label>
			</div>
			<div class="field">
				<input type="text" class="input input-auto input-big" id="password"
					name="content" size="200" placeholder="请输入发送内容" />
			</div>
		</div>
		<div class="form-button">
			<button class="button bg-main" type="submit">添加</button>
				<button class="button " type="reset">重置</button>
		</div>
	</form>
</div>