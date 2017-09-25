<?php
namespace app\controllers;

use app\controllers\BasicsController;
use lib\models\Ads;
use lib\models\Adstype;
use yii;

/**
 * @description 基类
 * @date   2015-03-31
 * @author gqa
 */
class TestController extends BasicsController
{
    public function actionIndex()
    {
        //$model = new Adstype();
        $model = Adstype::findOne(85);

        $result = $model->hasMany('lib\models\Ads',['type'=>'type'])->asArray()->all();
        print_r($result);
        //print_r($model->getOrders());
    }

}
