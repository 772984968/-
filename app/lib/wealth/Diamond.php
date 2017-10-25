<?phpnamespace lib\wealth;use Yii;use lib\models\Setting;use lib\nodes\Notice;use lib\models\AccountLevel;class Diamond extends BaseWealth{    protected $fieldName = 'diamond';       //对应用户字段    protected $logClassName = '\lib\models\UserDiamondLog';    //对应的日志文件名    public $error = '';    //转换成余额    public function toWallet($number)    {        if($number < 0) {            $this->error = '参数不能为空';            return false;        }        $t = Yii::$app->getDb()->beginTransaction();        //减去钻石        if(!$this->sub([            'number' => $number,            'type' => \Config::WALLET_CHANGE_DIAMOND,        ])) {            $t->rollBack();            return false;        }        //加余额        $diamondClass = Yii::$app->factory->getwealth('wallet', $this->userModel);        if(!$diamondClass->add([            /**            'number' => $number * Setting::keyTovalue('diamond2money') / 100,            **/            'number'=>$number*AccountLevel::diamondWithdraw($this->userModel->credits),            'type' => \Config::WALLET_CHANGE_DIAMOND,        ])) {            $t->rollBack();            return false;        }        $t->commit();        return true;    }    //转换成我气豆    public function toBeans($number) {        if($number < 0) {            $this->error = '参数不能为空';            return false;        }        $t = Yii::$app->getDb()->beginTransaction();        //减去钻石        if(!$this->sub([            'number' => $number,            'type' => \Config::BEANS_CHANGE_DIAMOND,        ])) {            $t->rollBack();            return false;        }        //加人气豆        $beansClass = Yii::$app->factory->getwealth('beans', $this->userModel);        if(!$beansClass->add([            'number' => $number,            'type' => \Config::BEANS_CHANGE_DIAMOND,        ])) {            $t->rollBack();            return false;        }        $t->commit();        return true;    }    public function add( $data ){        if(parent::add($data)) {            if(!in_array($data['type'],[20011])) {                Notice::wallet($this->userModel, [                    'title' => \Config::walletLogMeaning()[$data['type']] ?? '',                    'time' => date('Y-m-d H:i:s'),                    'content' => $data['number'],                    'unit' => '钻石',                    'type' => 'wallet',                    'describe' => static::getDescribe($data['type'], $data['note'] ?? '我的钻石帐户'),                ]);            }            return true;        } else {            return false;        }    }    public function sub( $data ) {        if(parent::sub($data)) {            if(!in_array($data['type'],[10003, 20011,20016])) {                Notice::wallet($this->userModel, [                    'title' => \Config::walletLogMeaning()[$data['type']] ?? '',                    'time' => date('Y-m-d H:i:s'),                    'content' => '-' . $data['number'],                    'unit' => '钻石',                    'type' => 'wallet',                    'describe' => static::getDescribe($data['type'], $data['note'] ?? '我的钻石帐户'),                ]);            }            return true;        } else {            return false;        }    }}