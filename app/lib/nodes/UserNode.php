<?phpnamespace lib\nodes;use Yii;use yii\extend\AdCommon;use lib\models\User;use lib\models\AccountLevel;use lib\models\Buddy;//用户类class UserNode{    public $error;                  //错误信息    public $userId;                 //用户ID    protected $_Identity;           //用户数据模型    public $operate;                //用户可用的操作方法    protected $operate_table;       //权限表    const USER_CACHE_NAME = 'user_';    const TOKEN_CACHE_NAME = 'token_';        //缓存数据    public function login( $model )    {        $this->_Identity = $model;        $this->userId = $model->iid;        //缓存用户信息        Yii::$app->getCache()->set(self::USER_CACHE_NAME.$model->iid, $model);        $this->setToken();        //缓存会员信息,及操作权限        Yii::$app->factory->getmember()->cache( $model->member );        return true;    }    //退出    public function logout()    {        $this->clearToken();        Yii::$app->cache->delete(self::USER_CACHE_NAME.$this->userId);    }    //设置令牌    public function setToken()    {        Yii::$app->cache->set(self::TOKEN_CACHE_NAME.$this->userId, $this->createToken());    }    //取令牌    public function getToken()    {        return Yii::$app->cache->get( self::TOKEN_CACHE_NAME.$this->userId );    }    //取帐号等级及对应的权限    public function getAccountLevel()    {        $credits = $this->getIdentity()->credits;        return AccountLevel::numberToRecord( $credits );    }    //消除令牌    public function clearToken()    {        Yii::$app->cache->delete( self::TOKEN_CACHE_NAME.$this->userId );    }    //通过token,user_id加载数据    public function loginByToken($token, $user_id)    {        $token_cache = Yii::$app->cache->get(self::TOKEN_CACHE_NAME.$user_id);        if( $token == $token_cache ) {            $this->_Identity = Yii::$app->cache->get(self::USER_CACHE_NAME.$user_id);            $this->userId = $this->_Identity->iid;            return true;        }        return false;    }    // 创建TOken    private static function createToken()    {        return md5(time(). AdCommon::randomkeys(20) . mt_rand(1000,9999));    }    //是否已登入    public function isLogin() {        return $this->_Identity ? true : false;    }    //取自己的数据资料    public function getIdentity()    {        if( empty( $this->_Identity ) ) {            $this->_Identity = User::findIdentity( $this->userId );        }        return $this->_Identity;    }    //添加好友    public function addBuddy($buddy_id)    {        if(Buddy::findOne(['user_id'=>$this->userId, 'buddy_id'=>$buddy_id])) {            $this->error = '该用户已在好友列表中!';            return false;        }        $buddyModel = new Buddy();        $buddyModel->user_id = $this->userId;        $buddyModel->buddy_id = $buddy_id;        if($buddyModel->save()) {            return true;        } else {            $this->error = AdCommon::modelMessage($buddyModel->errors);            return false;        }    }    //取用户信息    public function getinfo()    {        $result =  User::find()                    ->select('head,nickname,llaccounts,signature,name,sex,province,city,vip_type,fans_number,follow_number,wy_accid')                    ->where(['iid'=>$this->userId])                    ->asArray()                    ->one();        $result['head'] = $this->get_head_url($result['head']);        return $result;    }    public static function get_head_url($head)    {        $head_arr = json_decode($head);        if($head_arr && is_object($head_arr)) {            if(empty($head_arr->groupname) ||  empty($head_arr->filename)) {                $url = Yii::$app->params['webpath'] . '/uploads/default_head.png';            } else {                $server = Yii::$app->params['imgServer'][$head_arr->group_name] ?? '';                $url = $server . $head_arr->group_name . '/' . $head_arr->filename;            }        } else {            $url = $head;        }        return $url ?? '';    }    }?>