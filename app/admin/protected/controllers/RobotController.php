<?php
namespace app\controllers;

use lib\models\User;
use yii;
use lib\components\AdCommon;
use yii\base\Model;
use lib\wealth\Pinyin;


// 用户控制器
class RobotController extends TemplateController
{

    public $config = [
        'modelName' => 'lib\models\User',
        'modelShortName' => 'User',
        'listUrl' => 'Robotindex',
        'addUrl' => 'Robotadd',
        'delUrl' => 'Robotdel',
        'chgUrl' => 'RobotEdit',
        'addTitle' => '添加',
        'addFormName' => '参数',
        'chgTitle' => '修改',
        'chgFormName' => '参数',
        'listTitle' => '标签列表',
        'listFormName' => '参数',
    ];

    // 可搜索的选项
    public function getSearch()
    {
        return [
            'username' => '帐号',
            'llaccounts' => '联联号'

        ];
    }

    //设置首页显示的数据
    protected function setIndexData()
    {
        $search = $this->get('search');
        $where  = 'is_robot=1';
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
        $primaryKey = $this->config['modelName']::primaryKey()[0];

        $query = $this->config['modelName']::find()
        ->where($where,$where_keyword)->orderBy($primaryKey.' DESC');

        $this->data['count'] = $query->count();

        $this->data['page']  = $this->page( $this->data['count'] );
        $page = \Yii::$app->getRequest()->get('page', 0);
        $start = $page>0 ? ($page-1)*20 : 0;
        $this->data['data']  = $query->offset($start)->limit(20)->asArray()->all();

        $this->data['searchvalue'] = $search;

    }

    public function actionIndex()
    {
        $this->data['search'] = $this->getSearch();
        $this->setIndexData();
        $this->data['config'] = $this->config;
        $this->data['title'] = $this->getIndexField();
        return $this->view('index');
    }

    public function actionAdd(){
        if( $this->isPost() )
        {
            $data = $this->post( $this->config['modelShortName'] );
            $model = new $this->config['modelName'];
            $data['is_robot']='1';
            $data['password_hash']='1';
            if($data['username']==''){
                    $this->error('账户不能为空');
            }

            if ($model::findByUsername($data['username'])||$model::findByEmail($data['username'])){
                $this->error('账号或邮箱已经存在');
            }

            $llacounts=$data['nickname'];
            $llacounts=mb_substr($llacounts, 0,rand(1,2));

            $ping=new Pinyin();
            $data['llaccounts']=$ping->get_pinyin($llacounts).rand(100,99999999);
            if (strlen($data['llaccounts'])%2==0){
                $data['vip_type']=5;
                $data['vip_start']=date('Y-m-d H:i:s');
                $data['vip_end']=date('Y-m-d H:i:s',strtotime('+1 year'));
            }
            $model->attributes = $data;
            if ($model::findByLlaccounts($model->llaccounts)){
                $this->error('联联账号已存在,请重试');
            }
            if ($model->save()){
                $model->registerWyAccid();
            }
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

        return $this->view('window');

    }



    //添加修改中定主的字段
    protected function getOption()
    {
        return [
            ['key'=>'username','value'=>'','html'=>'text','option'=>'','changedisabled'=>1],
            ['key'=>'head','value'=>'','html'=>'image','option'=>''],
            ['key'=>'nickname','value'=>'宝宝','html'=>'text','option'=>''],
            ['key'=>'signature','value'=>'','html'=>'text','option'=>''],
            ['key'=>'name','value'=>'','html'=>'text','option'=>''],
            ['key'=>'sex','value'=>'','html'=>'select','option'=>['男'=>'男','女'=>'女']],
            ['key'=>'province','value'=>'广东省','html'=>'text','option'=>''],
            ['key'=>'city','value'=>'深圳市','html'=>'text','option'=>''],
            ['key'=>'address','value'=>'','html'=>'text','option'=>''],
            ['key'=>'follow_number','value'=>'0','html'=>'text','option'=>''],
            ['key'=>'fans_number','value'=>'0','html'=>'text','option'=>''],
        ];
    }


    //主页中显示的字段名
    public function getIndexField()
    {
        return [
            'iid',
            'username',
            'llaccounts',
            'nickname',
            'signature',
            'name',
            'province',
            'city',
            'address',
            'follow_number',
            'fans_number',
            'vip_type',
        ];
    }
}
?>