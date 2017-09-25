<?php
namespace app\controllers;

use app\controllers\SellerController;
use lib\components\AdCommon;
use lib\models\Activity;
use lib\models\Activitytype;



/**
 * 首页活动类型控制器
 */
class ActivityController extends SellerController
{
    private $_article;
    public function init()
    {
        parent::init();
        $this->_article = new Activity();
    }

/**
* @desc    广告列表
* @access  public
* @param   void
* @return  void
*/
    
public function actionIndex(){
    $search = $this->get('search');
    $where  = '1=1';
    //搜索
    if(!empty($search['type']) && !empty($search['keyword']))
    {
        $where .= " and " . $search['type'] ." like '%" . $search['keyword'] . "%'";
    }
    //分类
    if(isset($search['cat_id']) && !empty($search['cat_id'])) $where .= " and er_activitytype.type=" . $search['cat_id'];
    //添加时间搜索
    if(!empty($search['stime']))
    {
        $stime = strtotime($search['stime']);
        $etime = empty($search['etime']) ? time() : strtotime($search['etime']);
        $where .= " and create_time between " . $stime ." and " . $etime;
    }

    $query = $this->query($this->_article ,'er_activitytype', $where);
    //var_dump($query['data']);die;
    $this->data['category'] = Activitytype::find()->asArray()->all();

    $this->data['count'] = $query['count'];
    $this->data['data']  = $query['data'];
    $this->data['page']  = $query['page'];
    $this->data['searchvalue'] = $search;
    $this->data['where'] = $where;

    $this->data['search'] = ['er_activity.id' => \yii::t('app', '文章ID'),
        'er_activity.name' => \yii::t('app', '活动名称'),
    ];
    return $this->view('list');
}




/**
* @desc    添加广告
* @access  public
* @param   void
* @return  void
*/
public function actionAdd()
{
    $ads = new Activity();
    if ($this->isPost())
    {
        $post = $this->post('Activity');

        if($post['type'] > 0){
            $post['create_time'] = time();

            $ads->attributes = $post;

            $ads->save();

            if (empty($ads->errors)) {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['index_activity_type']);
            } else {
                $this->error(AdCommon::modelMessage($ads->errors));
            }
        }else{
            $this->error(\yii::t('app', '类型必须选择！'));
        }
    } else {
        $type = \Yii::$app->request->get('type');
        $ads['type'] = $type;
    }
    $activitytype = new Activitytype();
    $adstype = $activitytype->adstypelist();

    $this->data['adstype']  = $adstype;
    $this->data['model'] = $ads;
    return $this->view('window');
}

    public function actionUp()
    {
        $id = \Yii::$app->request->post('data');
        $result = Activity::findOne($id);
        if($result) {
            $result->listorder = time();
            $result->type .='';
            $result->save();
            $this->success(\yii::t('app', 'success'));
        } else {
            $this->error(\yii::t('app', 'fail'));
        }

    }
/**
* @desc   修改广告
* @access  public
* @param   int $id
* @return  void
*/
public function actionUpdate()
{
    $id = $this->get('id');
    $ad = Activity::findOne($id);
    if ($this->isPost())
    {
        $post = $this->post('Activity');
        $ad->attributes = $post;
        $ad->save();
        if (empty($ad->errors))
        {
            $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['index_activity_type']);
        }
        else
        {
            $this->error(AdCommon::modelMessage($ad->errors));
        }
    }
    $activitytype = new Activitytype();
    $adstype = $activitytype->adstypelist();
    $this->data['adstype']  = $adstype;
    $this->data['model'] = $ad;
    return $this->view('window');
}


/**
 * @desc    删除广告
 * @access  public
 * @param   int $id
 * @return  void
 */
public function actionDel()
{
    $id = $this->post('data');
    if (empty($id)) $this->error(\yii::t('app', 'error'));
    $result = Activity::findOne($id)->delete();
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