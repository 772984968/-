<?phpnamespace lib\wealth;use lib\components\AdCommon;use lib\models\User;use lib\models\Setting;use Yii;class BaseWealth{    public $userModel;          //指向用户模型    protected $fieldName;       //对应用户字段    protected $logClassName;    //对应的日志文件名    public $error = '';    public static $describe = [        10001 => [            '付款帐户:联联平台',            '交易对象:%target',        ],        10002 => [            '付款帐户:支付宝帐户',            '交易对象:我的现金帐户',        ],        10003 => [            '付款帐户:我的钻石帐户',            '交易对象:我的现金帐户',        ],        10005 => [            '付款帐户:联联平台',            '交易对象:%target',        ],        10008 => [            '付款帐户:我的现金帐户',            '交易对象:%target',        ],        10009 => [            '付款帐户:我的现金帐户',            '交易对象:%target',        ],        10010 => [            '付款帐户:联联平台',            '交易对象:%target',        ],        10012 => [            '付款帐户:联联平台',            '交易对象:我的余额帐户',        ],        20004 => [            '付款帐户:我的现金帐户',            '交易对象:我的余额帐户',        ],        20007 => [            '付款帐户:联联平台',            '交易对象:我的钻石帐户',        ],        20006 => [            '付款帐户:联联平台',            '交易对象:我的钻石帐户',        ],        30014 => [            '付款帐户:我的钻石帐户',            '交易对象:我的欢乐豆帐户',        ],    ];    public static function getDescribe($type, $target='')    {        $describe = static::$describe[$type] ?? '';        if($target && $describe) {            foreach ($describe as $key => $string) {                $describe[$key] = str_replace('%target', $target, $string);            }        } else {            $describe = ['',''];        }        return $describe;    }    //减少    public function sub( $data )    {        if($data['number']<0) {            return true;        }        //用户还能增加积分        $fieldName = $this->fieldName;        if($this->userModel->$fieldName < $data['number']) {            $this->error = \Yii::t('common',$fieldName).'数量不足';            return false;        }        $this->userModel->$fieldName -= $data['number'];        $data['number'] = 0 - $data['number'];        $t = \Yii::$app->getDb()->beginTransaction();        if(!$this->userModel->save()) {            $t->rollBack();            return false;        }        //添加到日志中        $data['user_id'] = $this->userModel->iid;        $logClassName = $this->logClassName;        $result =$logClassName::add( $data );        if($result) {            $t->commit();        } else {            $t->rollBack();        }        return $result;    }    //增加    public function add( $data )    {        if($data['number']<0) {            return true;        }        //用户还能增加积分        $fieldName = $this->fieldName;        $this->userModel->$fieldName += $data['number'];                $t = \Yii::$app->getDb()->beginTransaction();        if(!$this->userModel->save()) {            $t->rollBack();            return false;        }        //添加到日志中        $data['user_id'] = $this->userModel->iid;        $logClassName = $this->logClassName;        $result =$logClassName::add( $data );        if($result) {            $t->commit();        } else {            $t->rollBack();        }        return $result;    }    //添加奖励    public function addReward( $data ) {        $t = \Yii::$app->getDb()->beginTransaction();        if($this->userModel->reward_count <  Setting::keyTovalue('max_reward')) {            $this->userModel->reward_count += $data['number'];            if(!$this->userModel->save()) {                $t->rollBack();                return false;            }            if(!Yii::$app->factory->getwealth('wallet', $this->userModel)->add($data)) {                $t->rollBack();                return false;            }            $t->commit();            return true;        } else {                        $walletdata = $diamonddata = $data;            $walletdata['number'] = round($data['number'] * Setting::keyTovalue('max_reward_money') / 100, 2);            $diamonddata['number'] = $data['number'] - $walletdata['number'];            $this->userModel->reward_count += $walletdata['number'];            if(!$this->userModel->save()) {                $t->rollBack();                return false;            }            if($walletdata['number']> 0 && !Yii::$app->factory->getwealth('wallet', $this->userModel)->add($walletdata)) {                $t->rollBack();                return false;            }            if($diamonddata['number']>0 && !Yii::$app->factory->getwealth('diamond', $this->userModel)->add($diamonddata)) {                $t->rollBack();                return false;            }            $t->commit();            return true;        }    }    //信息描述字段}