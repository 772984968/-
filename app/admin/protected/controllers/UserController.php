<?phpnamespace app\controllers;use lib\models\User;use lib\models\Agent;use lib\models\UserWalletLog;use yii;use yii\base\Request;use yii\data\Pagination;use lib\models\Sign;use lib\models\Signdate;//用户控制器class UserController extends TemplateController{    public $config = [        'modelName' => 'lib\models\User',        'modelShortName' => 'User',        'listUrl' => 'UserManage',        'addUrl' => '',        'delUrl' => '',        'chgUrl' => 'UserManageEdit',        'addTitle' => '添加',        'addFormName' => '参数',        'chgTitle' => '修改',        'chgFormName' => '参数',        'listTitle' => '标签列表',        'listFormName' => '参数',        'invUrl' => 'UserManageInv',//推荐列表        'recordUrl' => 'UserManageRecord',//推荐列表        'cancelUrl'=>'UserManageCancel',    ];    //可搜索的选项    public function getSearch()    {        return [            'username' => '帐号',            'llaccounts'=>'联联号'        ];    }    public function actionIndex()    {        $this->data['search'] = $this->getSearch();        $this->setIndexData();        $this->data['config'] = $this->config;        $this->data['title'] = $this->getIndexField();        return $this->view('index');    }    public function actionChange()    {        $id = $this->get('id');        if ( empty($id) ){            $this->error(\Yii::t('app', 'error'));        }        $model = $this->config['modelName']::findOne($id);        if ($this->isPost())        {            $data = $this->post( $this->config['modelShortName'] );            if(empty($data['password_hash'])) {                unset($data['password_hash']);            }            $model->attributes = $data;            if(!empty($data['password_hash'])) {                $model->setPassword($data['password_hash']);            }            if ($model->save())            {                $this->success(\Yii::t('app', 'success'), \yii::$app->params['url'][$this->config['listUrl']]);            }            else            {                $this->error(AdCommon::modelMessage($model->errors));            }        }        $setting = $this->getOption();        foreach($setting as $k => $v)        {            if($v['key'] != 'password_hash') {                $setting[$k]['value'] = $model[$v['key']];            }        }        $this->data['fieldOption'] = $setting;        $this->config['method'] = 'change';        $this->data['config'] = $this->config;        return $this->view('../template/window');
    }

    /**
     *
     * @author li
     *         邀请账号列表
     */
    public function actionInvitations()
    {        $where = [
            'and'
        ];
        if ($this->isPost()) {           $searchvalue = [];
            $data = Yii::$app->getRequest()->post();
            if (! empty(($data['search']['stime']))) {
                $stime = $data['search']['stime'];
                array_push($where, [
                    '>=',
                    'created_at',
                    $stime
                ]);
                $searchvalue['stime'] = $stime;
            }
            if (! empty(($data['search']['etime']))) {

                $etime = $data['search']['etime'];
                array_push($where, [
                    '<=',
                    'created_at',
                    $etime
                ]);
                $searchvalue['etime'] = $etime;
            }

            if ($data['search']['vip_type'] != '') {
                $vip_type = $data['search']['vip_type'];
                array_push($where, [
                    '=',
                    'vip_type',
                    $vip_type
                ]);
                $searchvalue['vip_type'] = $vip_type;
            }

            $this->data['searchvalue'] = $searchvalue;
        }

    //    "select sum(number) as number FROM at_user_diamond_log where userid in(select iid from at_user where incke='jiahua') AND ";

        // 代理级别
        $id = $_REQUEST['id'];        $model = new $this->config['modelName']();
        $user = $model::findone($id);
        array_push($where, [
            '=',
            'inviteCode',
            $user->llaccounts
        ]);        $query=$model::find()->where($where);        $invites = $query->joinWith('agentinfo')->asArray()->all();        $diamondtotal=0;            foreach ($invites as $key=>$vo){            $invites[$key]['diamondsum']=UserWalletLog::sum($vo['iid']);            $diamondtotal+=$invites[$key]['diamondsum'];       }       $this->data['username']=$user->username;        $this->data['config'] = $this->config;
        $this->data['invites'] = $invites;
        $this->data['id']=$id;        $this->data['diamondtotal']=$diamondtotal;        return $this->view('invitations');            }            /**             * author li             * 会员充值记录             */    public function actionRecord(){        $where=['and'];        $id=$_REQUEST['id'];        if ($this->isPost()){            $searchvalue=[];            $data=Yii::$app->getRequest()->post();            if (!empty(($data['search']['stime']))){                $stime=$data['search']['stime'];                array_push($where,['>=', 'create_time', $stime]);                $searchvalue['stime']=$stime;            }            if (!empty(($data['search']['etime']))){                $etime=$data['search']['etime'];                array_push($where,['<=', 'create_time', $etime]);                $searchvalue['etime']=$etime;            }            if (!empty(($data['search']['type']))){                $type=$data['search']['type'];                array_push($where,['=', 'type', $type]);                $searchvalue['type']=$type;            }            $this->data['searchvalue']=$searchvalue;        }        $user= $this->config['modelName']::findone($id);        array_push($where,['=','user_id',$id]);        $orders = UserWalletLog::find()->where($where)->all();        $this->data['config'] = $this->config;        $this->data['orders'] = $orders;        $this->data['user']=$user;        return $this->view('record');  }    /**     *@author li     *用户签到列表     */    public  function  actionSign(){        $sign=new Sign();//         ->where(['user_id'=>$user_id])        $data=$sign->find()        ->joinWith('userinfo')         ->all();        $this->data['list']=$data;        return  $this->view('signlist');  }  /**   *@author li   *用户签到详情   */  public  function  actionSigndetails(){      $iid=\Yii::$app->request->get('iid');      $signdate=new Signdate();      $data=$signdate->find()->where(['sign_id'=>$iid])->all();      $this->data['list']=$data;      return  $this->view('signdetails');  }    //添加修改中定主的字段    protected function getOption()    {        $list = array_merge(['0'=>'请选择'],\lib\models\Agent::getKeyName());        return [            ['key'=>'username','value'=>'','html'=>'text','option'=>'','changedisabled'=>1],            ['key'=>'agent','value'=>'','html'=>'select','option'=>$list],            ['key'=>'password_hash','value'=>'','html'=>'password','option'=>''],        ];    }    //主页中显示的字段名    public function getIndexField()    {        return [            'iid',            'username',            'llaccounts',            'vip_type',            'agentinfo',            'inviteCode',            'created_at',            'wallet',            'diamond',        ];    }    //设置首页显示的数据    protected function setIndexData()    {        $search = $this->get('search');        $where  = '1=1';        $where_keyword = [];        //搜索        if(!empty($search['type']) && !empty($search['keyword']))        {            $where .= " and " . $search['type'] ." like :like";            $where_keyword = [':like'=>"%{$search['keyword']}%"];        }        //添加时间搜索        if(!empty($search['stime']))        {            $stime = strtotime($search['stime']);            $etime = empty($search['etime']) ? time() : strtotime($search['etime']);            $where .= " and UNIX_TIMESTAMP(create_time) between " . $stime ." and " . $etime;        }        $query = $this->config['modelName']::find()            ->with(['agentinfo','memberinfo'])            ->where($where,$where_keyword);        $this->data['count'] = $query->count();        $this->data['page']  = $this->page( $this->data['count'] );        $page = \Yii::$app->getRequest()->get('page', 0);        $start = $page>0 ? ($page-1)*20 : 0;        $data  = $query->offset($start)->limit(20)->asArray()->all();        foreach($data as $key => $row) {            $data[$key]['agentinfo'] = $row['agentinfo']['name'] ?? '';            $data[$key]['vip_type'] = $row['memberinfo']['name'] ?? '';        }        $this->data['data']  = $data;        $this->data['searchvalue'] = $search;    }//     //取消会员//     public function actionCancelmember(){//         if ($this->isAjax()){//             $uid = Yii::$app->getRequest()->get('id');//             $sql = "UPDATE at_user set vip_type=0,vip_start='0000-00-00',vip_end='0000-00-00' WHERE iid=$uid";//             $rs=Yii::$app->getDb()->createCommand($sql)->execute();//             if ($rs){//                 return json_encode(['code'=>'取消成功']);//             }else{//                 return json_encode(['code'=>'取消失败']);//             }//  }//     }    /*public function actionClearmemberone()    {        $uid = Yii::$app->getRequest()->get('uid');        $sql = "UPDATE at_user set vip_type=0,vip_start='0000-00-00',vip_end='0000-00-00' WHERE iid=$uid";        Yii::$app->getDb()->createCommand($sql)->execute();        $this->success(\yii::t('app', 'success'), \yii::$app->params['url'][$this->config['listUrl']]);    }*/}?>