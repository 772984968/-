<?phpnamespace lib\forms;use Yii;use yii\base\Model;use lib\models\User;use lib\models\Channel;use lib\wyim\chatroom;use lib\wyim\channel as wychannel;//直播频道class ChannelForm extends Model{    public $name;    public $user_id;    public $id;    public $img;    public $password;    public function scenarios()    {        return [            'create' => [                'user_id',                'name',                'img',                'password',            ],            'delete' => [                'user_id',                'id',            ]        ];    }    /**     * @inheritdoc     */    public function rules()    {        return [            [['username', 'name', 'id'], 'required'],            ['name', 'string', 'max'=>'30'],            [['user_id', 'id'], 'integer'],        ];    }    /*public function attributeLabels()    {        return [        ];    }*/    public function create()    {        if($this->validate())        {           //检查名称是否存在了            $result = Channel::findOne(['name'=>$this->name]);            if (!empty($this->img)){                $userModel=\Yii::$app->factory->getuser();                /*非vip用户不能上传                if ($userModel->vip_type!=5)                {                    $this->addError('img','只有VIP才能更更换直播头像');                    return false;                }*/               $img_url=Channel::updateimg($this->img);            }else{                $img_url='';            }            /**             *返回直播             */            if($result) {                if($result['user_id'] == $this->user_id) {                    $result->ctime = date('Y-m-d H:i:s');                    if (!empty($this->img)){                        $result->img=$img_url;                    }                    $result->password = $this->password ?? '';                    $result->save();                    $data = $result->attributes;                    $data['grade'] = \lib\channel\liveTelecastRanking::getGrade($this->user_id);                    \lib\wyim\chatroom::clearinfo($result['cid']);                    \lib\wyim\channel::begin($result['cid'], $data['grade']);                    \lib\channel\ranking::addDiamond($this->user_id, 0);                    return $data;                }                $this->addError('iid','名称已存在!');                return false;            }            /**             *更新直播             */            $result = Channel::findOne(['user_id'=>$this->user_id]);            if($result) {                if(wychannel::updateLiveRoom($result->cid, $this->name)) {                    $result->name = $this->name;                    $result->ctime = date('Y-m-d H:i:s');                    if (!empty($this->img)){                        $result->img=$img_url;                    }                    $result->password = $this->password ?? '';                    $result->save();                    $data = $result->attributes;                    $data['grade'] = \lib\channel\liveTelecastRanking::getGrade($this->user_id);                    \lib\wyim\channel::begin($result['cid'], $data['grade']);                    \lib\channel\ranking::addDiamond($this->user_id, 0);                    return $data;                } else {                    $this->addError('iid','直播创建失败,请稍候再试');                    return false;                }            }            /**             *创建直播             */            $result = wychannel::createLiveRoom($this->name);            if(isset($result->ret)) {                $t = Yii::$app->getDb()->beginTransaction();                $model = new Channel();                $model->attributes = [                    'name' => $result->ret->name,                    'cid' => $result->ret->cid,                    'pushUrl' => $result->ret->pushUrl,                    'httpPullUrl' => $result->ret->httpPullUrl,                    'hlsPullUrl' => $result->ret->hlsPullUrl,                    'rtmpPullUrl' => $result->ret->rtmpPullUrl,                    'user_id' => $this->user_id,                    'ctime' => date('Y-m-d H:i:s'),                    'status' => 0,                    'password' => $this->password ?? '',                    'look_number' => 0,                    'img' => $img_url,                    'type' => 0,                ];                if($model->save()) {                    $userModel = User::findOne($this->user_id);                    $resultroom = chatroom::create($userModel->wy_accid, $this->name);                    if($resultroom) {                        $model->roomid = $resultroom->roomid;                        $model->save();                        $t->commit();                        $data = $model->attributes;                        $data['grade'] = \lib\channel\liveTelecastRanking::getGrade($this->user_id);                        \lib\wyim\channel::begin($result->ret->cid, $data['grade']);                        \lib\channel\ranking::addDiamond($this->user_id, 0);                        return $data;                    } else {                        wychannel::deleteChanel($result->ret->cid);                        $t->rollBack();                        return false;                    }                } else {                    wychannel::deleteChanel($result->ret->cid);                    $t->rollBack();                    $this->addError('iid','创建直播频道失败!');                    return false;                }            } else {                $this->addError('iid',$result['msg'] ?? '创建直播频道失败!');                return false;            }        }    }    public function delete()    {        if($this->validate())        {            $model = Channel::findOne(['user_id'=>$this->user_id, 'iid'=>$this->id]);            if(!$model) {                $this->addError('iid','您没创建该直播!');                return false;            }            $cid = $model->cid;            $model->delete();            wychannel::deleteChanel($cid);            return true;        }    }}