<?php
namespace app\controllers;
use yii\web\Controller;
use Yii;

class IndexController extends Controller
{

    public function actionIndex()
    {
        return $this->renderPartial('index');
    }


}