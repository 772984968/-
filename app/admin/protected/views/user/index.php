<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '';
?>

<div class="dux-tools">
    <div class="tools-function clearfix">
        <?php if(!empty($search)): ?>

        <?php echo html::beginForm('', 'GET');?>
                <div class="form-inline">
                    <div class="form-group">搜索： </div>
                    <div class="form-group">
                        <div class="field">
                            <select class="input" name="search[type]" id="class_id">
                                <option value=>请选择</option>
                                <?php if(!empty($search) && is_array($search)) :?>

                                    <?php foreach($search as $k=>$v):?>
                                        <?php if($k=='angency_only') continue;?>
                                    <?php if($k != 'create_time'): ?>
                                        <option value="<?= Html::encode($k)?>" <?php if (isset($searchvalue['type']) && $searchvalue['type'] == $k)  echo "selected"?> ><?= Html::encode($v)?></option>
                                    <?php endif; ?>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-left: 10px;">
                        <div class="field">
                            <input type="text" class="input" id="keyword" name="search[keyword]" size="30" value="<?php echo isset($searchvalue['keyword'])?$searchvalue['keyword']: '';?>" placeholder="关键词">
                        </div>
                    </div>

                    <?php if(isset($search['create_time'])): ?>
                        <div class="form-group" style="margin-left: 10px;">添加时间：</div>
                        <div class="form-group">
                            <div class="field">
                                <?php echo html::textInput('search[stime]',isset($searchvalue['stime'])?$searchvalue['stime']: null, ['class' => 'input', 'size' => 25, 'id' => 'stime', 'placeholder' => '开始时间']); ?>
                                <?php echo html::textInput('search[etime]',isset($searchvalue['etime'])?$searchvalue['etime']: null, ['class' => 'input', 'size' => 25, 'id' => 'etime', 'placeholder' => '结束时间']); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($search['angency_only'])): ?>
                        <div class="form-group" style="margin-left: 10px;">仅显示代理：</div>
                        <?php echo html::dropDownList('search[angency_only]', null, ['1'=>'是', '0'=>'否']); ?>
                    <?php endif; ?>

                    <div class="form-button">
                        <button class="button" type="submit">查询</button>
                    </div>
                </div>
        <?php echo html::endForm();?>
        <?php endif; ?>

        <?php if(!empty($config['addUrl'])): ?>
            <div class="button-group float-right">
                <a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url'][$config['addUrl']]);?>"> 添加</a>
            </div>
        <?php endif; ?>

    </div>
 </div>
<div class="admin-main">
    <div class="panel dux-box">
        <div class="table-responsive">
            <table id="table" class="table table-hover table-tr-hide">
                <tbody>
                    <!--显示表格标题-->
                    <tr class="trshow">
                        <?php foreach($title as $key => $fieldName): ?>
                            <th>
                                <?php if(is_string($fieldName)): ?>
                                    <?= \Yii::t('common', $fieldName ) ?>
                                <?php else: ?>
                                    <?= \Yii::t('common', $key ) ?>
                                <?php endif; ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>

                    <!--显示字段内容-->
                    <?php foreach($data as $v) :?>
                        <tr  class="trshow">
                            <?php foreach($title as $key => $fieldName): ?>
                                <td>

                                <?php if(is_string($fieldName)): ?>
                                    <?php $value = $v[$fieldName] ?>
                                    <?php if(in_array($fieldName,['image']) && !empty( $value ) ): ?>

                                        <!--显示为图片-->
                                        <img src="<?= $value ?>" style="max-height:50px;" />

                                    <?php elseif(in_array($fieldName, ['dt'])  && !empty( $value ) ): ?>

                                        <!--显示为日期-->
                                        <?php if(is_string( $value )): ?>
                                            <?= Html::encode( $value ) ?>
                                        <?php else: ?>
                                            <?= date('Y-m-d H:i:s',$value ) ?>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <!--文本-->
                                        <?= Html::encode( $value ) ?>

                                    <?php endif; ?>
                                <?php else: ?>

                                        <?= Html::encode( $fieldName[$v[$key]] ?? '' ) ?>
                                <?php endif ?>
                                </td>
                            <?php endforeach; ?>

                            <td>
                            <?php if(!empty($config['chgUrl'])): ?>
                                <!-- update -->
                                 <a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url'][$config['chgUrl']]);?>?id=<?= Html::encode($v['iid'])?>" title="修改"></a>
                                 <a class="button bg-blue button-small icon-eye" href="<?php echo Url::toRoute(yii::$app->params['url'][$config['invUrl']]);?>?id=<?= Html::encode($v['iid'])?>" title="邀请的用户列表"></a>
                                 <a class="button bg-blue button-small icon-money" href="<?php echo Url::toRoute(yii::$app->params['url'][$config['recordUrl']]);?>?id=<?= Html::encode($v['iid'])?>" title="查看用户的消费记录"></a>
                           
                            <?php endif; ?>
                            <?php if(!empty($config['delUrl'])): ?>
                                <!-- delete -->
                                <a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url'][$config['delUrl']]);?>?isCsrf=0" data="<?= Html::encode($v['iid'])?>" title="删除"></a>
                            <?php endif; ?>
                      <!--      <button  class="button bg-red button-small icon-trash-o "   id="cancelmember" onclick="cancelmember(this);" title="取消会员" url="<?php echo Url::toRoute(yii::$app->params['url'][$config['cancelUrl']]);?>?id=<?= Html::encode($v['iid'])?>"> 取消会员</button>
                      -->  
                            </td>
                        </tr>
                    <?php endforeach;?>
               
                </tbody>
            </table>
        </div>
        <div class="panel-foot table-foot clearfix">
            <!-- 分页 start-->
            <?php if(!empty($page)): ?>
                <?= $this->render('../_page', ['count' => $count, 'page' => $page]) ?>
            <?php endif ?>
            <!-- 分页 end-->
        </div>
    </div>
</div>
<script>
    Do.ready('base', function () {
        $('#table').duxTable();
        $('#stime').duxTime();
        $('#etime').duxTime();
    });
</script>

<script>
//取消会员

function cancelmember(th){
	
	if(confirm('取消之后不可恢复，确定要取消会员吗？')){
		var url=$(th).attr('url')
	        $.get(url, function(result){
			 if(result)
			 {			
				  alert(JSON.parse(result)['code']);
				 }			 
			  });
		}
}
</script>









