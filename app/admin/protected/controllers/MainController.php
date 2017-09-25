<?php
namespace app\controllers;

use app\controllers\SellerController;
use app\library\AdminLibrary;
use app\library\MenuLibrary;

/**
* @description 后台管理主界面
* @date   2015-03-26
* @author gqa
*/
class MainController extends SellerController
{
    /**
     * [actionIndex description]
     * @return [type] [description]
     */
    public function actionIndex()
    {

        if ($this->admin['is_admin'] == 1)   # 超级管理员
        {

            $menuList = MenuLibrary::app()->getUserMenu();
        }
        else                                # 角色
        {
            $power = \yii::$app->session['power'];

            $menuList = MenuLibrary::app()->setPower2($power);
        }

        //var_dump($menuList);die;
        $menuList = json_encode($menuList);
        $this->data['menuList'] = $menuList;
        return $this->view();
    }

    /**
     * 默认首页
     * @return null
     */
    public function actionDefault()
    {
        return $this->view();
    }

}   