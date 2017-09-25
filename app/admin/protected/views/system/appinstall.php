<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '美影管理系统-客户端安装版本';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="">客户端安装版本</a>
        </div>
    </div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
        <div class="table-responsive">
            <table id="table" class="table table-hover ">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <th>客户端类型</th>
                        <th>版本号</th>
                        <th>手机标识码</th>
                        <th>密钥</th>
                        <th>添加时间</th>
                    </tr>
                    <?php if(is_array($data)&&!empty($data)) :?>
                        <?php foreach($data as $v) :?>
                            <tr>
                                <td><?= Html::encode($v->id)?></td>
                                <td><?= Html::encode(yii::$app->params['appInstallType'][$v->install_type])?></td>
                                <td><?= Html::encode($v->version)?></td>
                                <td><?= Html::encode($v->mark)?></td>
                                <td><?= Html::encode($v->sign)?></td>
                                <td><?= Html::encode($v->install_time)?></td>
                            </tr>
                        <?php endforeach;?> 
                    <?php endif;?>
                </tbody>
            </table>
        </div>
        <div class="panel-foot table-foot clearfix">
            <!-- 分页 start-->
            <?= $this->render('../_page', ['count' => $count, 'page' => $page]) ?>
            <!-- 分页 end-->
        </div>
    </div>
</div>
<script>
    Do.ready('base', function () {
        $('#table').duxTable();
    });
</script>