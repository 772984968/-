<?phpnamespace api\controllers;use lib\channel\liveTelecastRanking;use Yii;use lib\models\Channel;use lib\channel\gift;use lib\wyim\chatroom;use lib\models\ActivityReward;use lib\models\User;use lib\activity\watch_live_box;//直播控制器class ChannelController extends BasisController{    public $formName = '\lib\forms\ChannelForm';    //创建直播频道    public function actionCreate()    {        parent::baseAction($this->formName, 'create');    }    //删除直播频道 -- 暂不用    public function actionDelete()    {        parent::baseAction($this->formName, 'delete');    }    //真播列表    public function actionList()    {        $isNext = Yii::$app->getRequest()->post('isNext');        $userId = Yii::$app->factory->getuser()->userId;        Channel::$key_name = "at_channel.iid";        $result = Channel::list($userId, $isNext, 'userinfo', 15);        foreach ($result as $key => $row) {            $row['status'] = \lib\wyim\channel::getStatus($row['cid']);            $row['look_number'] = \lib\wyim\chatroom::get_online_count($row['cid']);            $row['userinfo']['head'] = \lib\nodes\UserNode::get_head_url($row['userinfo']['head']);            $row['img'] = $row['userinfo']['head'];            $result[$key] = $row;        }        $this->success(['list'=>$result]);    }    //赠送礼物    public function actionSendGifts()    {        $userModel = Yii::$app->factory->getuser();        $userId = $userModel->userId;        $rq = Yii::$app->getRequest();        $receiverId = intval($rq->post('receiverId'));  //接收者ID        $payType = intval($rq->post('payType'))+1;        //礼物类型        $payNumber = intval($rq->post('payNumber'));      //礼物数量        $diamond_number = $userModel->diamond;        $diamond_number += 0.01;        if($result = gift::send($userId, $receiverId, $payType, $payNumber)) {            $creditsClass=\Yii::$app->factory->getCredits($userId);            $creditsClass->gift(ceil($diamond_number-$result['diamond']), $userId);            $this->success($result);        } else {            $this->error(gift::$error);        }    }    //用户进入直播    public function actionInto()    {        $cid = Yii::$app->getRequest()->post('cid');        if(!$cid) {            $this->error('请输入直播间ID');        }        $channelinfo = Channel::findOne(['cid'=>$cid]);        if(!$channelinfo) {            $this->error('请输入正确的直播间ID');        }        $channelinfo = $channelinfo->toArray();        $user_id = Yii::$app->factory->getuser()->userId;        $anchor = Yii::$app->factory->createuser($channelinfo['user_id'])->getinfo();        $anchor['iid'] = $channelinfo['user_id'];        $anchor['mutual'] = \lib\models\Fans::aFollowb($user_id, $channelinfo['user_id']);        $anchor['grade'] = \lib\channel\matchRanking::getGrade($channelinfo['user_id']) ?: \lib\channel\ranking::getGrade($channelinfo['user_id']);        chatroom::addUser($cid, $user_id);        //添加机器人人数        self::actionRobots($cid,$channelinfo['roomid']);        $roominfo = chatroom::getinfo($cid);        $anchor['onlineusercount'] = $roominfo->onlineusercount;        //取直播间的用户信息        $users = \lib\models\User::find()                ->select('iid,nickname,vip_type as vip,head,signature as slogan,fans_number as fanscount,follow_number as concerncount,llaccounts')                ->where(['in', 'iid', $roominfo->members])                ->asArray()                ->all();        foreach($users as $key => $row) {            $users[$key]['head'] = \lib\nodes\UserNode::get_head_url($row['head']);        }        $on_line_count = chatroom::get_online_count($cid);        //发送进入直播间信息        $userModel = Yii::$app->factory->getuser();        chatroom::sendGift($channelinfo['roomid'], $userModel ,['onlineusercount'=>$on_line_count], '3');        //宝箱状态        watch_live_box::$userModel = $userModel;        //$box = ActivityReward::getActivityStatus('watch_live');        $activity = watch_live_box::getUnused(2);        //取用户会员权限 -- 有多少免费的弹幕        $barrage = Yii::$app->factory->get('barrage', $userModel)->surplus_number();        $this->success([            'anchor'=>$anchor,            'users'=>$users,            'activity' => $activity,            'barrage' => $barrage,            'wealth' => $userModel->getWealth(),        ]);    }    //机器人进入直播    public static function actionRobots($cid,$roomId){        $userModel=new User();        //取随机用户数据        $all_id=$userModel->find()->where(['is_robot'=>1])->select('iid')->asArray()->all();        $ids=array_column($all_id, 'iid');        $max_leng=count($ids)>15?15:count($ids);        $rand_key=array_rand($ids,rand(5,$max_leng));        foreach ($rand_key as $key=>$value){            $user_ids[]=$ids[$value];        }        $user_data=$userModel->find()->where(['iid'=>$user_ids])->select('iid')->asArray()->all();        //循环添加人数        foreach ($user_data as $key=>$value){            $model=User::findOne(['iid'=>$value['iid']]);            chatroom::addUser($cid,$value['iid']);//添加用户            $on_line_count = chatroom::get_online_count($cid);//直播在线人数            chatroom::sendGift($roomId, $model,['onlineusercount'=>$on_line_count], '3');       }    }    //结束直播    public function actionFinish()    {        $user_id = Yii::$app->factory->getuser()->userId;        $rst = Channel::findOne(['user_id' => $user_id]);        if($rst) {            $grade = \lib\channel\liveTelecastRanking::getGrade($user_id);            $result = \lib\wyim\channel::finish($rst['cid'], $grade);            $creditsClass=\Yii::$app->factory->getCredits($user_id);            $creditsClass->live(date('h',strtotime($result['duration'])));            $this->success( $result );        } else {            $this->error('您没有开直播');        }    }    //搜索    public function actionSearch()    {        $keyword = Yii::$app->getRequest()->post('keyword');        if(!$keyword) {            $this->error('请输入关键字');        }        $result = Channel::find()            ->select('at_channel.*,at_user.nickname,at_user.head,at_user.vip_type,at_user.fans_number')            ->innerJoin('at_user',"at_user.iid=at_channel.user_id")            ->where(['like','at_channel.name',$keyword])            ->orWhere(['like', 'at_user.nickname',$keyword])            ->orWhere(['like', 'at_user.llaccounts', $keyword])            ->asArray()            ->all();        foreach ($result as $key => $row) {            $userinfo = [                'nickname' => $row['nickname'],                'head' => \lib\nodes\UserNode::get_head_url($row['head']),                'vip_type' => $row['vip_type'],                'fans_number' => $row['fans_number'],            ];            unset($row['nickname']);            unset($row['head']);            unset($row['vip_type']);            unset($row['fans_number']);            $row['status'] = \lib\wyim\channel::getStatus($row['cid']);            $row['look_number'] = \lib\wyim\chatroom::get_online_count($row['cid']);            $row['userinfo'] = $userinfo;            $result[$key] = $row;        }        $this->success(['list'=>$result]);    }    //查直播状态    public function actionStatus()    {        $cid = Yii::$app->getRequest()->post('cid');        if(!$cid) {            $this->error('请输入cid');        }        $status = \lib\wyim\channel::channelstats($cid);        if($status === false) {            $status = \lib\wyim\channel::getStatus($cid);        } else {            \lib\wyim\channel::changeStatus($cid, $status);        }        $this->success(['status' => (string)$status]);    }    //发送弹幕    public function actionBarrage()    {        $rq = Yii::$app->getRequest();        $roomid = $rq->post('roomid');        $content = $rq->post('content');        if(!$content) {            $this->error('内容不能为空');        }        $userModel = Yii::$app->factory->getuser();        if(Yii::$app->factory->get('barrage', $userModel)->send($roomid, $content)) {            $this->success([                'diamond' => (string)$userModel->diamond,                'beans' => (string)$userModel->beans,            ]);        } else {            $this->error('发送失败,请稍候再试');        }    }}