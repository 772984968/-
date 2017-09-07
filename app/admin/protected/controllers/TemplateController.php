<?php 
namespace app\controllers;
use yii\rhy\Config;
use lib\components\AdCommon;

/**
后台模版控制器
*/
abstract class TemplateController extends SellerController
{
    /*public $config = [
        'modelName' => 'lib\models\Adminlabel',
        'modelShortName' => 'Adminlabel',
        'listUrl' => 'adminlabel',
        'addUrl' => 'AddLabel',
        'listUrl' => 'adminlabel',
        'delUrl' => 'DelLabel',
        'chgUrl' => '',
        'addTitle' => '添加',
        'addFormName' => '参数',
        'chgTitle' => '修改',
        'chgFormName' => '参数',
        'listTitle' => '标签列表',
        'listFormName' => '参数',
    ];*/
    
    /**
     * [actionIndex 主列表]
     * @return [type] [description]
     */
    public function actionIndex()
    {

        $this->data['search'] = $this->getSearch();
        $this->setIndexData();
        $this->data['config'] = $this->config;
        $this->data['title'] = $this->getIndexField();
        return $this->view('../template/index');
    }

    //取搜索框字段
    protected function getSearch()
    {
        return [];
    }

    //设置首页显示的数据
    protected function setIndexData()
    {
        $search = $this->get('search');
        $where  = '1=1';
        $where_keyword = [];
       
        //搜索
        if(!empty($search['type']) && !empty($search['keyword']))
        {
            $where .= " and " . $search['type'] ." like :like";
            $where_keyword = [':like'=>"%{$search['keyword']}%"];
        }
        //添加时间搜索
        if(!empty($search['stime']))
        {
            $stime = strtotime($search['stime']);
            $etime = empty($search['etime']) ? time() : strtotime($search['etime']);
            $where .= " and UNIX_TIMESTAMP(create_time) between " . $stime ." and " . $etime;
        }
        $query = $this->config['modelName']::find()
                    ->where($where,$where_keyword);

        $this->data['count'] = $query->count();
        $this->data['page']  = $this->page( $this->data['count'] );
        $this->data['data']  = $query->all();
        $this->data['searchvalue'] = $search;
        
    }


    //设置添加，修改需要生成的表单选项
    abstract protected function getOption();
    
   /* return [
        array('name'=>'上级','key'=>'pid','value'=>'0','html'=>'select','option'=>$tree),
        array('name'=>'名称','key'=>'name','value'=>'','html'=>'text','option'=>''),
        array('name'=>'路径','key'=>'url','value'=>'','html'=>'text','option'=>''),
        array('name'=>'显示','key'=>'is_show','value'=>'1','html'=>'radio','option'=>'否,是'),
        array('name'=>'新窗口打开','key'=>'is_new','value'=>'','html'=>'radio','option'=>'否,是'),
        array('name'=>'排序','key'=>'order','value'=>'','html'=>'text','option'=>''),
    
    ];*/


    /**
    * 函数的含义说明 :
    * 设置列表页面，要显示的字段
    */
    abstract protected function getIndexField();
    /*{
        return [
            'name',
        ];
    }*/

    /**
     * [actionIndex 删除]
     * @return [type] [description]
     */
    public function actionDel()
    {

        $id = $this->post('data');

        if( empty($id) ){
            $this->error(\Yii::t('app', 'error'));
        }

        $query = $this->config['modelName']::findOne($id);

        if($query && $query->delete())
        {
            $this->success(\Yii::t('app', 'success'));
        }
        else
        {
            $this->error(\Yii::t('app', 'fail'));
        }
    }



    /**
     * [actionIndex 添加]
     * @return [type] [description]
     */
    public function actionAdd()
    {

        if( $this->isPost() )
        {
            $data = $this->post( $this->config['modelShortName'] );

            $model = new $this->config['modelName'];
            $model->attributes = $data;
            $model->save();

            if(empty($model->errors))
            {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url'][$this->config['listUrl']]);
            }
            else
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
        }

        $this->data['fieldOption'] = $this->getOption();

        $this->config['method'] = 'add';
        $this->data['config']= $this->config;

        return $this->view('../template/window');
    }

    /**
     * [actionIndex 修改]
     * @return [type] [description]
     */
    public function actionChange()
    {
        $id = $this->get('id');
        if ( empty($id) ){
            $this->error(\Yii::t('app', 'error'));
        }

        $model = $this->config['modelName']::findOne($id);


        if ($this->isPost()) 
        {
            $data = $this->post( $this->config['modelShortName'] );

            $model->attributes = $data;

            if ($model->save())
            {
                $this->success(\Yii::t('app', 'success'), \yii::$app->params['url'][$this->config['listUrl']]);
            }
            else
            {
                $this->error(AdCommon::modelMessage($model->errors));
            }
        }


        $setting = $this->getOption();  

        foreach($setting as $k => $v)
        {
            $setting[$k]['value'] = $model[$v['key']];
        }


        $this->data['fieldOption'] = $setting;
        $this->config['method'] = 'change';
        $this->data['config'] = $this->config;

        return $this->view('../template/window');
    }

}
?>