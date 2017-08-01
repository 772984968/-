<?php

use yii\helpers\Html;

$this->title = '管理系统-后台';
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <?php echo Html::csrfMetaTags()?>
        <title><?php echo Html::encode($this->title)?></title>
        <?php $this->head()?>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="viewport" content="width=device-width"/>
        <link href="/style/css/pintuer.css" rel="stylesheet">
        <link href="/style/css/login.css" rel="stylesheet">
        <link href="/style/css/admin.css" rel="stylesheet">
        <script src="/style/js/jquery.js"></script>
        <script src="/style/js/pintuer.js"></script>
        <script>
            var duxConfig = {
                //基础配置
                'baseDir': '/style/js/',
                'baseUrl': '/style/',
                'uploadUrl' : "/upload/image?isCsrf=1",
				'fileUploadUrl' : "/upload/image?isCsrf=2",
                'editorUploadUrl' : "/upload/editor?isCsrf=0",
                //自定义配置
                'libDir': '/style/js/',
                'sessId': 'qidgqofhk3o4b6umso1rmph8b2',
            };
        </script>
        <script src="/style/js/do.js"></script>
        <script src="/style/js/config.js"></script> 
        <script src="/style/js/definition.js"></script>
    </head>
    <body>
		
        <?php $this->beginBody()?>
        <?php echo $content;?>
        <?php $this->endBody()?>
    </body>
</html>
<?php $this->endPage()?>
