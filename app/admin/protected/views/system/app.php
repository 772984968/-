<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '美影管理系统-客户端';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href=""> 客户端</a>
        </div>
        <div class="button-group float-right">
            <a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['addApp']);?>"> 添加</a> 
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
                        <th>备注</th>
                        <th>升级地址</th>
                        <th>状态</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                    <?php if(is_array($data)&&!empty($data)) :?>
                        <?php foreach($data as $v) :?>
                            <tr>
                                <td><?= Html::encode($v->id)?></td>
                                <td><?= Html::encode(yii::$app->params['appInstallType'][$v->type])?></td>
                                <td><?= Html::encode($v->version)?></td>
                                <td style="width:150px;"><?= Html::encode($v->remark)?></td>
                                <td><?= Html::encode($v->remove)?></td>
                                <td>
                                    <?php if(1==$v->status):?>
                                        <span class="tag bg-green">正常</span>
                                    <?php else:?>
                                        <span class="tag bg-red">禁用</span>
                                    <?php endif;?>
                                </td>
                                <td><?= Html::encode(date('Y-m-d H:i:s', $v->addtime))?></td>
                                <td>                         
                                    <?php if(in_array('upApp', $power)):?>
                                        <a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url']['upApp']);?>?id=<?= Html::encode($v->id)?>" title="修改"></a>
                                    <?php endif; ?>
                                    <?php if(in_array('delApp', $power)):?>
                                        <a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url']['delApp']);?>?isCsrf=0" data="<?= Html::encode($v->id)?>" title="删除"></a>
                                    <?php endif; ?>
                                </td>
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