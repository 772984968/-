<?php
namespace app\controllers;

use app\controllers\SellerController;
use yii\helpers\Url;
use lib\components\AdCommon;
use app\library\ArticlecatLibrary;
use lib\models\Articlecat;

/**
* @description 后台管理主界面
* @date   2016-01-20
* @author lijunwei
*/
class ArticlecatController extends SellerController
{
    /**
     * [actionIndex 菜单列表]
     * @return [type] [description]
     */
    public function actionIndex()
    {
        $this->data['data'] = ArticlecatLibrary::app()->getMenu();
        // echo "<pre>";
        // print_r($this->data['data']);
        return $this->view();
    }

    /**
     * [actionIndex 添加菜单]
     * @return [type] [description]
     */
    public function actionAdd()
    {
    	
        $model = new Articlecat();

        if ($this->isPost())
        {
            $form = $this->post('Articlecat');
            $form['parent_id']   = empty($form['parent_id']) ? 0 : $form['parent_id'];
            $form['sort_order'] = empty($form['sort_order']) ? 0 : $form['sort_order'];
            $form['addtime']  = time();
            $model->attributes = $form;
            //$model->scenario   = 'insert';
            if ($model->validate())
            {
                $model->save();
                $this->success(\Yii::t('app', 'success'), \yii::$app->params['url']['articlecat']);
            }
            else
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
        }

        $articlecat = ArticlecatLibrary::APP()->getSelectMenu();

        $this->data['articlecat'] = $articlecat;
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
        $model = Articlecat::findOne(['cat_id' => $id]);

        if ($this->isPost())
        {
            $form = $this->post('Articlecat');
            $form['parent_id']   = empty($form['parent_id']) ? 0 : $form['parent_id'];
            $form['sort_order'] = empty($form['sort_order']) ? 0 : $form['sort_order'];

            $model->attributes = $form;

            if ($model->validate())
            {
                $model->save();
                $this->success(\Yii::t('app', 'success'), \yii::$app->params['url']['articlecat']);
            }
            else
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
        }

        $articlecat = ArticlecatLibrary::APP()->getSelectMenu();

        $this->data['articlecat'] = $articlecat;
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

        $query = Articlecat::findOne(['parent_id' => $id]);

        if ($query['cat_id']) $this->error(\Yii::t('app', 'delArticlecat'));

        if(Articlecat::findOne(['cat_id' => $id])->delete()) {
            $this->success(\Yii::t('app', 'success'));
        } else {
            $this->error(\Yii::t('app', 'fail'));
        }
    }

}
