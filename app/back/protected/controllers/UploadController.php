<?php
namespace app\controllers;
use yii\web\Controller;
use lib\upload\Uploader;
use Yii;
/**
 * 文件上传
 */
class UploadController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * 文件上传
     */
    public function actionImage()
    {

        $tmp_name = $_FILES['file']['tmp_name'] ?? '';
        $name = $_FILES['file']['name'] ?? '';
        $imgType   = pathinfo($name, PATHINFO_EXTENSION);
        if($tmp_name && is_file($tmp_name)) {

            //取要裁剪的大小
            $rq = Yii::$app->getRequest();
            $width = intval($rq->get('width'));
            $height = intval($rq->get('height'));

            //裁剪图片
            $img = new \yii\extend\Image($tmp_name,'');
            if($width && $height) {
                $img->noopsyche($width,$height)->_tmpImg;
            }

            //上传图片
            $ret = fastdfs_storage_upload_by_filename($tmp_name,$imgType);
            if($ret) {
                echo json_encode(['code'=>200, 'data'=>$ret]);
                die;
            }
        }
        echo json_encode(['code'=>400]);
        die;
/*
        $upload = new \app\components\Upload();
        $file = $upload->uploadImage($_FILES['file'], true,0);

        if($file) {
            $rq = Yii::$app->getRequest();
            //取宽度跟高度
            $width = intval($rq->get('width'));
            $height = intval($rq->get('height'));
            if($width && $height) {
                $img = new \yii\extend\Image('d:\tmp\7D38689E0A7A.jpg','');
                $thunb_path = $img->noopsyche($width,$height)->_tmpImg;//自定义裁切
                echo $thunb_path;die;
            }
            echo json_encode(['code'=>200, 'date'=> ['url'=>$upload->_file_name]]);
        } else {
            echo json_encode(['code'=>400]);
        }
        die;*/
    }
}

