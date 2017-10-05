<?php

use yii\widgets\LinkPager;
?>
<html>
    <head>
        <?php foreach($data as $row): ?>
            <?php var_dump($row); ?>
        <?php endforeach; ?>
    </head>
    <body>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
    </body>
</html>