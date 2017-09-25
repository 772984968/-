<?php
namespace app\controllers;
use app\controllers\BasicsController;
use app\components\Upload;
/**
 * 文件上传
 */
class UploadController extends BasicsController
{
    /**
     * [__construst description]
     * @return [type] [description]
     */
    public function init()
    {
        parent::init();
    }

    /**
     * 文件上传
     */
    public function actionImage()
    {
        $file = \yii::$app->upload->uploadImage($_FILES['file'], true,$this->get('isCsrf'));
        $return['status'] = $file;
        $return['data']   = ['url' => \yii::$app->upload->_file_name, 'title' => ''];
        $return['info']   = $file ? \yii::t('app', 'uploadSuccess') : \yii::$app->upload->_errors;
        $this->ajaxReturn($return);
    }

    /**
     * 编辑器上传
     */
    public function actionEditor()
    {
        $file = \yii::$app->upload->uploadImage($_FILES['imgFile'], true);
        $return['url']   = \yii::$app->upload->_file_name;
        $return['error']   = $file ? 0 : \yii::$app->upload->_errors;
        echo json_encode($return);
    }
}

