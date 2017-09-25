<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2015/5/28
 * Time: 21:51
 */
namespace app\controllers;
use yii\web\Controller;
use Yii;

class IndexController extends Controller
{

    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
	
    public function actionLogin()
    {
        return $this->renderPartial('login');
    }



    //上传文件
    public function actionUpload()
    {
        return $this->renderPartial('upload');
    }

    //退出
    public function actionUnlogin()
    {
        \Yii::$app->session->removeAll();
        AdCommon::success();
    }


}