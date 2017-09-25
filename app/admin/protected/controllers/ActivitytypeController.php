<?php
namespace app\controllers;

use app\controllers\SellerController;
use lib\components\AdCommon;
use lib\models\Setting;
use lib\models\Activitytype;


/**
 * 首页活动类型控制器
 */
class ActivitytypeController extends SellerController
{
    private $_adstype;

    /**
     * @desc
     * @access
     * @param
     * @return
     */
    public function init()
    {
        parent::init();
        $this->_adstype = new Activitytype();
    }

    /**
     * @desc    广告类型列表
     * @access  public
     * @param   void
     * @return  void
     */
    public function actionIndex()
    {
        $adstype = new Activitytype();
        $query = $this->query($adstype,'ads','1','listorder DESC');
        $this->data['count'] = $query['count'];
        $this->data['data']  = $query['data'];
        $this->data['page']  = $query['page'];
        return $this->view();
    }


    /**
     * @desc    添加广告类型
     * @access  public
     * @param   void
     * @return  void
     */
    public function actionAdd()
    {
        $adstype = new Activitytype();
        if ($this->isPost())
        {
            $post = $this->post('Activitytype');
            $post['addtime'] = time();

            $adstype->attributes = $post;
            $adstype->save();

            if (empty($adstype->errors))
            {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['index_activity_type']);
            }
            else
            {
                $this->error(AdCommon::modelMessage($adstype->errors));
            }
        }

        $this->data['model'] = $adstype;
        return $this->view('window');
    }


    /**
     * @desc   修改广告类型
     * @access  public
     * @param   int $id
     * @return  void
     */
    public function actionUpdate()
    {
        $id = $this->get('id');
        $adtype = Activitytype::findOne($id);
        if ($this->isPost())
        {
            $post = $this->post('Activitytype');
            $adtype->attributes = $post;
            $adtype->save();

            if (empty($adtype->errors))
            {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['index_activity_type']);
            }
            else
            {
                $this->error(AdCommon::modelMessage($adtype->errors));
            }
        }

        $this->data['model'] = $adtype;
        return $this->view('window');
    }


    /**
     * @desc    删除广告类型
     * @access  public
     * @param   int $id
     * @return  void
     */
    public function actionDel()
    {
        $id = $this->post('data');
        if (empty($id)) $this->error(\yii::t('app', 'error'));
        $info = Activitytype::findOne($id);
        $result = $info->delete();
        if ($result)
        {
            \lib\models\Activity::deleteAll(['type' => $info->type]);
            $this->success(\yii::t('app', 'success'));
        }
        else
        {
            $this->error(\yii::t('app', 'fail'));
        }
    }


    /**
     * @desc    广告列表
     * @access  public
     * @param   void
     * @return  void
     */
    public function actionAds()
    {
        $ads = new Ads();
        $query = $this->query($ads,'',[],'listorder DESC,id DESC');
        $adstype = $this->_adstype->adstypelist();
        $this->data['count'] = $query['count'];
        $this->data['data']  = $query['data'];
        $this->data['page']  = $query['page'];
        $this->data['adstype']  = $adstype;

        return $this->view();
    }


    /**
     * @desc    添加广告
     * @access  public
     * @param   void
     * @return  void
     */
    public function actionAddads()
    {
        $ads = new Ads();
        if ($this->isPost())
        {
            $post = $this->post('Ads');
            if($post['type'] > 0){
                $post['addtime'] = time();

                $ads->attributes = $post;
                $ads->save();

                if (empty($ads->errors))
                {
                    $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['ads']);
                }
                else
                {
                    $this->error(AdCommon::modelMessage($ads->errors));
                }
            }else{
                $this->error(\yii::t('app', '类型必须选择！'));
            }
        }
        $adstype = $this->_adstype->adstypelist();
        $this->data['adstype']  = $adstype;
        $this->data['model'] = $ads;
        return $this->view();
    }


    /**
     * @desc   修改广告
     * @access  public
     * @param   int $id
     * @return  void
     */
    public function actionUpads()
    {
        $id = $this->get('id');
        $ad = Ads::findOne($id);
        if ($this->isPost())
        {
            $post = $this->post('Ads');
            $ad->attributes = $post;
            $ad->save();
//			echo "<pre>";
//			var_dump($ad->errors);die;
            if (empty($ad->errors))
            {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['ads']);
            }
            else
            {
                $this->error(AdCommon::modelMessage($ad->errors));
            }
        }
        $adstype = $this->_adstype->adstypelist();
        $this->data['adstype']  = $adstype;
        $this->data['model'] = $ad;
        return $this->view();
    }


    /**
     * @desc    删除广告
     * @access  public
     * @param   int $id
     * @return  void
     */
    public function actionDelads()
    {
        $id = $this->post('data');
        if (empty($id)) $this->error(\yii::t('app', 'error'));
        $result = Ads::findOne($id)->delete();
        if ($result)
        {
            $this->success(\yii::t('app', 'success'));
        }
        else
        {
            $this->error(\yii::t('app', 'fail'));
        }
    }

}