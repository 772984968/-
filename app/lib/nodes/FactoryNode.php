<?phpnamespace lib\nodes;use Yii;use lib\models\User;//工厂类class FactoryNode extends \yii\base\Component{    private $userNode;      //用户类    private $wealths;        //财富类    //取用户类    public function getuser( $user_id = 0 )    {        if(!$this->userNode) {            $this->userNode = \lib\models\User::findOne($user_id);            if($this->userNode) {                $this->userNode->userId = $user_id;            }        }        return $this->userNode;    }    public function createuser($userid=0)    {        $model = \lib\models\User::findOne($userid);        if(!$model) {            $model =  new \lib\models\User();        }        return  $model;    }    public function get($type,User $userModel) {        return $this->getwealth($type,$userModel);    }    //取财富    public function getwealth($type,User $userModel)    {        if(isset($this->wealths[$type])) {            $wealthClass = $this->wealths[$type];        } else {            $method = 'get'.ucfirst($type);            if(method_exists($this,$method)) {                $wealthClass = $this->$method();                $this->wealths[$type] = $wealthClass;            } else {                throw new \Exception('type错误');            }        }        $wealthClass->userModel = $userModel;        return $wealthClass;    }    //创建钻石类    public function getDiamond(){        return new \lib\wealth\Diamond();    }    //创建钱包类    public function getWallet(){        return new \lib\wealth\Wallet();    }    //创建欢乐豆类    public function getBeans() {        return new \lib\wealth\Beans();    }    //取弹幕类    public function getBarrage() {        return new \lib\channel\Barrage();    }    //创建积分类    public function getCredits(){        return new \lib\wealth\Credits();    }}