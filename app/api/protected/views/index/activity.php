<?php
use yii\helpers\Html;
USE yii\helpers\HtmlPurifier; //636
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>为二次元用户创造价值的社交服务平台</title>
    <link rel="stylesheet" href="/assets/css/normalize.css" />
    <link rel="stylesheet" href="/assets/css/oun-pl.css" />
    <link rel="stylesheet" href="/assets/css/select-conter.css" />
    <meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
</head>
<body>
<div class="select-wrap2">
    <div class="select-conter">
        <div class="text-diso">
            <?= $result->content ?>
        </div>
    </div>
</div>
</body>
<script src="/assets/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="/assets/js/size.js"></script>
<script type="text/javascript" src="/assets/js/selectpl.js"></script>
</html>
