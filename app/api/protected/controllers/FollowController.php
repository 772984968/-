<?phpnamespace api\controllers;use lib\wyim\channel;use Yii;use lib\models\User;use lib\models\Fans;use lib\channel\matchRanking;//关注控制器class FollowController extends BasisController{    //添加关注    public function actionAdd()    {        $userId = Yii::$app->factory->getuser()->userId;        $follow_user_id = Yii::$app->getRequest()->post('user_id');        if($userId == $follow_user_id) {            $this->error('不能关注自己!');        }        if(!$followModel = User::findOne($follow_user_id)) {            $this->error('用户不存在!');        }        if(Fans::addFollow($userId, $follow_user_id)) {            //发送聊天室信息            $channelinfo = $followModel->channelinfo;            matchRanking::addFollow($follow_user_id);   //排行            if($channelinfo && channel::getStatus($channelinfo['cid'])) {                $grade = \lib\channel\rankingMonth::getGrade($follow_user_id) ?? \lib\channel\ranking::getGrade($follow_user_id);                                $rst = ['grade'=> (string)$grade ];                \lib\wyim\chatroom::sendGift($channelinfo->roomid, User::findOne($userId), $rst, '4');            }            $this->success(['user_id'=>$follow_user_id]);        } else {            $this->error('关注失败,请稍候再试!');        }    }    //取消关注    public function actionCencel()    {        $userId = Yii::$app->factory->getuser()->userId;        $follow_user_id = Yii::$app->getRequest()->post('user_id');                if(Fans::cencelFollow($userId, $follow_user_id)) {            matchRanking::subFollow($follow_user_id);            $this->success(['user_id'=>$follow_user_id]);        } else {            $this->error('取消关注失败,请稍候再试!');        }    }    //我的粉丝列表    public function actionMyfans()    {        $userId = Yii::$app->factory->getuser()->userId;        $isNext = Yii::$app->getRequest()->post('isNext');        $result = Fans::getMyFansList($userId, $isNext);        $this->success(['list'=>$result ?? []]);    }    //我的关注列表    public function actionMyfollow()    {        $userId = Yii::$app->factory->getuser()->userId;        $isNext = Yii::$app->getRequest()->post('isNext');        $result = Fans::getMyFollowList($userId, $isNext);        $this->success(['list'=>$result ?? []]);    }    //其他人的粉丝列表    public function actionOtherfans()    {        $userId = Yii::$app->factory->getuser()->userId;        $rq = Yii::$app->getRequest();        $isNext = $rq->post('isNext');        $other_user_id = $rq->post('user_id');        $result = Fans::getOtherFansList($other_user_id, $userId, $isNext);        $this->success(['list'=>$result ?? []]);    }        //他人的关注列表    public function actionOtherfollow()    {        $userId = Yii::$app->factory->getuser()->userId;        $rq = Yii::$app->getRequest();        $isNext = $rq->post('isNext');        $other_user_id = $rq->post('user_id');        $result = Fans::getOtherFollowList($other_user_id, $userId, $isNext);        $this->success(['list'=>$result ?? []]);    }}