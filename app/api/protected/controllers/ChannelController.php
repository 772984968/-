<?phpnamespace api\controllers;use lib\channel\liveTelecastRanking;use Yii;use lib\models\Channel;use lib\channel\gift;use lib\wyim\chatroom;use lib\models\ActivityReward;//直播控制器class ChannelController extends BasisController{    public $formName = '\lib\forms\ChannelForm';    //创建直播频道    public function actionCreate()    {        parent::baseAction($this->formName, 'create');    }    //删除直播频道 -- 暂不用    public function actionDelete()    {        parent::baseAction($this->formName, 'delete');    }    //真播列表    public function actionList()    {        $isNext = Yii::$app->getRequest()->post('isNext');        $userId = Yii::$app->factory->getuser()->userId;        Channel::$key_name = "at_channel.iid";        $result = Channel::list($userId, $isNext, 'userinfo', 15);                foreach ($result as $key => $row) {            $row['status'] = \lib\wyim\channel::getStatus($row['cid']);            $row['look_number'] = \lib\wyim\chatroom::get_online_count($row['cid']);            $row['userinfo']['head'] = \lib\nodes\UserNode::get_head_url($row['userinfo']['head']);            $result[$key] = $row;        }        $this->success(['list'=>$result]);    }    //赠送礼物    public function actionSendGifts()    {        $userId = Yii::$app->factory->getuser()->userId;        $rq = Yii::$app->getRequest();        $receiverId = intval($rq->post('receiverId'));  //接收者ID        $payType = intval($rq->post('payType'))+1;        //礼物类型        $payNumber = intval($rq->post('payNumber'));      //礼物数量        if($result = gift::send($userId, $receiverId, $payType, $payNumber)) {            $this->success(['diamond'=>$result]);        } else {            $this->error(gift::$error);        }    }    //用户进入直播    public function actionInto()    {        $cid = Yii::$app->getRequest()->post('cid');        if(!$cid) {            $this->error('请输入直播间ID');        }        $channelinfo = Channel::findOne(['cid'=>$cid]);        if(!$channelinfo) {            $this->error('请输入正确的直播间ID');        }        $channelinfo = $channelinfo->toArray();        $user_id = Yii::$app->factory->getuser()->userId;        $anchor = Yii::$app->factory->createuser($channelinfo['user_id'])->getinfo();        $anchor['iid'] = $channelinfo['user_id'];        $anchor['mutual'] = \lib\models\Fans::aFollowb($user_id, $channelinfo['user_id']);        $anchor['grade'] = \lib\channel\matchRanking::getGrade($channelinfo['user_id']) ?: \lib\channel\ranking::getGrade($channelinfo['user_id']);        chatroom::addUser($cid, $user_id);        $roominfo = chatroom::getinfo($cid);        $anchor['onlineusercount'] = $roominfo->onlineusercount;        //取直播间的用户信息        $users = \lib\models\User::find()                ->select('iid,nickname,vip_type as vip,head,signature as slogan,fans_number as fanscount,follow_number as concerncount,llaccounts')                ->where(['in', 'iid', $roominfo->members])                ->asArray()                ->all();        foreach($users as $key => $row) {            $users[$key]['head'] = \lib\nodes\UserNode::get_head_url($row['head']);        }        $on_line_count = chatroom::get_online_count($cid);        //发信息        $userModel = Yii::$app->factory->getuser();        chatroom::sendGift($channelinfo['roomid'], $userModel ,['onlineusercount'=>$on_line_count], '3');        //宝箱状态        ActivityReward::$userModel = $userModel;        //$box = ActivityReward::getActivityStatus('watch_live');        $activitys = ActivityReward::getActivityRows('watch_live');        $activity_id = ActivityReward::getActivity('watch_live');        foreach($activitys as $key => $activity) {            $activitys[$key]['receive'] = ActivityReward::getstatus($activity);            $activitys[$key]['activation'] = $activity['iid'] == $activity_id ? '1' : '0';        }        $this->success([            'anchor'=>$anchor,            'users'=>$users,            'activity' => $activitys,        ]);    }    //结束直播    public function actionFinish()    {        $user_id = Yii::$app->factory->getuser()->userId;        $rst = Channel::findOne(['user_id' => $user_id]);        if($rst) {            $grade = \lib\channel\liveTelecastRanking::getGrade($user_id);            $result = \lib\wyim\channel::finish($rst['cid'], $grade);            $this->success( $result );        } else {            $this->error('您没有开直播');        }    }    //搜索    public function actionSearch()    {        $keyword = Yii::$app->getRequest()->post('keyword');        if(!$keyword) {            $this->error('请输入关键字');        }        $result = Channel::find()            ->select('at_channel.*,at_user.nickname,at_user.head,at_user.vip_type,at_user.fans_number')            ->innerJoin('at_user',"at_user.iid=at_channel.user_id")            ->where(['like','at_channel.name',$keyword])            ->orWhere(['like', 'at_user.nickname',$keyword])            ->orWhere(['like', 'at_user.llaccounts', $keyword])            ->asArray()            ->all();        foreach ($result as $key => $row) {            $userinfo = [                'nickname' => $row['nickname'],                'head' => \lib\nodes\UserNode::get_head_url($row['head']),                'vip_type' => $row['vip_type'],                'fans_number' => $row['fans_number'],            ];            unset($row['nickname']);            unset($row['head']);            unset($row['vip_type']);            unset($row['fans_number']);            $row['status'] = \lib\wyim\channel::getStatus($row['cid']);            $row['look_number'] = \lib\wyim\chatroom::get_online_count($row['cid']);            $row['userinfo'] = $userinfo;            $result[$key] = $row;        }        $this->success(['list'=>$result]);    }    //查直播状态    public function actionStatus()    {        $cid = Yii::$app->getRequest()->post('cid');        if(!$cid) {            $this->error('请输入cid');        }        $status = \lib\wyim\channel::channelstats($cid);        if($status === false) {            $status = \lib\wyim\channel::getStatus($cid);        } else {            \lib\wyim\channel::changeStatus($cid, $status);        }        $this->success(['status' => (string)$status]);    }}