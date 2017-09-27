<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<h4>多文件上传</h4>
<?php if(Yii::$app->session->hasFlash('success')):?>
    <div class="alert alert-danger">
        <?=Yii::$app->session->getFlash('success')?>
    </div>
<?php endif ?>
<?php $form=ActiveForm::begin([
    'id'=>'upload',
    'enableAjaxValidation' => false,
    'options'=>['enctype'=>'multipart/form-data']
]);
?>
<?= $form->field($model, 'file')->fileInput() ?>
<?=  Html::submitButton('提交', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>
<?php ActiveForm::end(); ?>

</body>
</html>