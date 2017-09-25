<?php
return [
    'url' => require_once dirname(__FILE__).'/url.php',
    'pageSize'     => '20',  # 分页显示条
    'ExprotMaxDay' => '31',
    'uploadprefix' => 'IMG_',
    'uploadPath'   => '../upload',
    'imagePath'    => '/images/',
    'filePath'     => '/file/',
    'thumbPath'    => '/thum/',
    'appInstallType' => ['WEB','andoid','IOS'],
	'circle_type' => [
					1 => 'cos',
					2 =>'绘画',
					3 =>'舞蹈',
					4 =>'音乐',
					5 => '未分类',
				]
];