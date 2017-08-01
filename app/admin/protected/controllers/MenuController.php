<?php 
namespace app\controllers;

use app\controllers\SellerController;
use yii\helpers\Url;
use lib\components\AdCommon;
use app\library\menuLibrary;
use lib\models\Power;

/**
* @description 后台管理主界面
* @date   2015-03-26
* @author gqa
*/
class MenuController extends SellerController
{
    /**
     * [actionIndex 菜单列表]
     * @return [type] [description]
     */
    public function actionIndex()
    {
        $this->data['data'] = menuLibrary::app()->getMenu();
        // print_r($this->data['data']);
        return $this->view();
    }

    /**
     * [actionIndex 添加菜单]
     * @return [type] [description]
     */
    public function actionAdd()
    {
        $model = new Power();

        if ($this->isPost()) 
        {
            $form = $this->post('Power');
            $form['pid']   = empty($form['pid']) ? 0 : $form['pid'];
            $form['order'] = empty($form['order']) ? 0 : $form['order'];
            $form['uptime']  = time();

            $model->attributes = $form;
            //$model->scenario   = 'insert';
            if ($model->validate()) 
            {
                $model->save();
                $this->success(\Yii::t('app', 'success'), \yii::$app->params['url']['menu']);
            }
            else
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
        }

        $power = menuLibrary::APP()->getSelectMenu();

        $this->data['power'] = $power;
        $this->data['model'] = $model;
        return $this->view();
    }

    /**
     * [actionIndex 修改菜单]
     * @return [type] [description]
     */
    public function actionEdit()
    {
        $id = $this->get('id');
        if (empty($id))  $this->error(\Yii::t('app', 'error'));

        $model = Power::findOne(['id' => $id]);

        if ($this->isPost()) 
        {
            $form = $this->post('Power');
            $form['pid']   = empty($form['pid']) ? 0 : $form['pid'];
            $form['order'] = empty($form['order']) ? 0 : $form['order'];

            $model->attributes = $form;

            if ($model->validate()) 
            {
                $model->save();
                $this->success(\Yii::t('app', 'success'), \yii::$app->params['url']['menu']);
            }
            else
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
        }

        $power = menuLibrary::APP()->getSelectMenu();
       
        $this->data['power'] = $power;
        $this->data['model'] = $model;
   
        return $this->view();
    }

    /**
     * [actionIndex 删除菜单]
     * @return [type] [description]
     */
    public function actionDelete()
    {
        $id = $this->post('data');
        if(empty($id)) $this->error(\Yii::t('app', 'error'));

        $query = Power::findOne(['pid' => $id]);
        if ($query['id']) $this->error(\Yii::t('app', 'delMenu'));

        if(Power::findOne(['id' => $id])->delete())
        {
            $this->success(\Yii::t('app', 'success'));
        }
        else
        {
            $this->error(\Yii::t('app', 'fail'));
        }
    }
}
?>