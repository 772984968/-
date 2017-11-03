<?phpnamespace api\controllers;use Yii;use yii\extend\AdCommon;use lib\models\VipVideo;use lib\models\VideoList;use lib\models\Channel;use lib\models\User;use yii\data\Pagination;use lib\wyim\video;class VipvideoController extends BasisController{    public function actionList()    {        $isNext = Yii::$app->getRequest()->post('isNext');        $userId = Yii::$app->factory->getuser()->userId;        $this->success(['list'=>VipVideo::list($userId,$isNext)]);    }    public function actionGetinfo()    {        $id = Yii::$app->getRequest()->post('id');        if(!$id) {            $this->error('请上传id');        }        $result = \lib\wyim\video::getinfo($id);        if($result)        {            $this->success($result);        }        else        {            $this->error('获取数据失败!');        }    }    //保存视频接口    public function actionSavevideo(){        $userModel=\Yii::$app->factory->getuser();        if ($userModel->vip_type!=5){            return $this->error('您不是VIP用户');        }        $data=\Yii::$app->request->post();        $cid=$data['cid'];        $channel=Channel::find()->where(['cid'=>$cid,'video_status'=>1])->one();        if (!$channel){            $this->error('录制时间太短或正在缓存中，请重试！');        }        $videoListModel=VideoList::find()->where(['cid'=>$cid,'user_id'=>null])->orderBy('iid desc')->one();       if (!$videoListModel){          $this->error('没有等待操作的文件');       }       $begin_time=$videoListModel->begin_time;         $end_time=$videoListModel->end_time;      if (($end_time-$begin_time)<=30*60*1000){           $this->error('直播时间大于30分钟才可保存');           return false;       }       $videoListModel->user_id=$userModel->iid;       $channel=Channel::find()->select('name,img')->where(['user_id'=>$userModel->iid])->one();       $videoListModel->video_name=$channel->name;       $videoListModel->img=$channel->img;            if ($videoListModel->save()){                $channel->video_status=0;                $channel->save();                $this->success();            }else{                $this->error('保存失败,请重试');            }    }    //用户视频直播列表    public  function actionSavevideolist(){//        $userModel=\Yii::$app->factory->getuser()->userId;        $user_id=\Yii::$app->request->post('user_id');        $page=\Yii::$app->request->post('page');        $userModel=User::findIdentity($user_id);        if(!$userModel){            $this->error('不存在该用户！');        }        $channel=Channel::findOne(['user_id'=>$user_id]);        $cid=$channel->cid;        if (!$channel){            $this->error('未创建直播间');            return false;         }         /**          *          *添加分页          */         $query=VideoList::find()->where(['cid'=>$cid,'user_id'=>$user_id]);         $pagination=new Pagination(['totalCount' => $query->count(),'defaultPageSize'=>10]);//分页对象\         $pagination->page=$page;         $videoListModel=$query->offset($pagination->offset)->limit($pagination->limit)->asArray()->orderBy('iid desc')->all();         //$videoListModel=VideoList::find()->where(['cid'=>$cid,'user_id'=>$user_id])->asArray()->all();     $data=[];    foreach ($videoListModel as $key =>$value){      $data[$key]['iid']=$value['iid'];      $data[$key]['user_id']=$value['user_id'];      $data[$key]['vid']=$value['vid'];      $data[$key]['cid']=$value['cid'];      $data[$key]['orig_url']=$value['orig_url'];      $data[$key]['orig_video_key']=$value['orig_video_key'];      $data[$key]['video_name']=$value['video_name'];      $data[$key]['long_time']=gmdate('H:i:s',($value['end_time']-$value['begin_time'])/(1000));      if ($value['img']==''){          $data[$key]['img']= \lib\nodes\UserNode::get_head_url($userModel->head);      }else{          $data[$key]['img']= \lib\nodes\UserNode::get_head_url($value['img']);      }      $data[$key]['head']=\lib\nodes\UserNode::get_head_url($userModel->head);      $data[$key]['nickname']=$userModel->nickname;      $data[$key]['vip_type']=$userModel->vip_type;      $data[$key]['name']=$channel->name;      $data[$key]['look']=$channel->look_number;      $data[$key]['ctime']=date('Y-m-d H:i:s',(integer)substr($value['begin_time'], 0,10));      $data[$key]['etime']=date('Y-m-d H:i:s',(integer)substr($value['end_time'], 0,10));  }        $dataArr['list']=$data;        $this->success($dataArr);   }   //删除视频接口    public  function actionVideodel(){        $data=\Yii::$app->request->post();        $vid=$data['vid'];        $user=\Yii::$app->factory->getuser();        $rs=VideoList::findOne(['user_id'=>$user->iid,'vid'=>$vid]);        if ($rs){            if ($rs->delete()){                video::delete($vid);//删除网易端                $this->success();            }        }else{           $this->error('视频不存在');        }    }}