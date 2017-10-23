<?phpnamespace lib\wealth;use Yii;use lib\models\Setting;use lib\models\User;use lib\models\Agent;use lib\nodes\Notice;class Wallet extends BaseWealth{    protected $fieldName = 'wallet';       //对应用户字段    protected $logClassName = '\lib\models\UserWalletLog';    //对应的日志文件名    public $error = '';    //转换成钻石    public function toDiamond($number)    {        if($number < 0) {            $this->error = '参数不能为空';            return false;        }        $t = Yii::$app->getDb()->beginTransaction();        //计算需要多少余额        $wallet_number = $number * 100 / Setting::keyTovalue('money2diamond');        //减去余额        if(!$this->sub([            'number' => $wallet_number,            'type' => \Config::DIAMOND_CHANGE_WALLET,        ])) {            $t->rollBack();            return false;        }        //加钻石        $diamondClass = Yii::$app->factory->getwealth('diamond', $this->userModel);        if(!$diamondClass->add([            'number' => $number,            'type' => \Config::DIAMOND_CHANGE_WALLET,        ])) {            $t->rollBack();            return false;        }        //推荐人奖励        if($this->userModel->inviteCode) {            $inviteUserModel = User::findByLlaccounts($this->userModel->inviteCode);            if(!Yii::$app->factory->getwealth('diamond', $inviteUserModel)->add([                'number' => $number * Setting::keyTovalue('recommend_recharge_reward') / 100,                'type' => \Config::DIAMOND_RECHARGE_RECOMMEND,                'source_user_id' => $this->userModel->iid,                'note' => $this->userModel->username,            ])) {                $t->rollBack();                return false;            }        }        //代理人奖励        $agents = Agent::getCacheList();        $use_count = 0;        $agents_count = count($agents);        $topuserModel = $this->userModel->getTop();        while($topuserModel)        {            if($topuserModel->agent) {                $reward_number = 0;                $userAgent = Agent::getCacheRow($topuserModel->agent);                foreach($agents as $akey => $agent) {                    if($userAgent['label'] >= $agent['label'] && !isset($agent['use'])) {                        $reward_number += $number * $agent['recharge_reward'] / 100;                        $agents[$akey]['use'] = 1;                        $use_count++;                    }                }                if($reward_number) {                    if(!Yii::$app->factory->getwealth('diamond', $topuserModel)->add([                        'number' => $reward_number,                        'type' => \Config::DIAMOND_RECHARGE_AGENT,                        'source_user_id' => $this->userModel->iid,                        'note' => $this->userModel->username,                    ])){                        $t->rollBack();                        return false;                    }                }                //所有奖都拿完了                if($use_count >= $agents_count) {                    break;                }            }            $topuserModel = $topuserModel->getTop();        }        $t->commit();        return true;    }    public function add( $data ){        if(parent::add($data)) {            Notice::wallet($this->userModel,[                'title' => \Config::walletLogMeaning()[$data['type']] ?? '',                'time' => date('Y-m-d H:i:s'),                'content' => $data['number'],                'unit' => '元',                'type' => 'wallet',                'describe' => static::getDescribe($data['type'], $data['note'] ?? '我的现金帐户' ),            ]);            return true;        } else {            return false;        }    }    public function sub( $data ) {        if(parent::sub($data)) {            if(!in_array($data['type'],[20004]))            {                Notice::wallet($this->userModel,[                    'title' => \Config::walletLogMeaning()[$data['type']] ?? '',                    'time' => date('Y-m-d H:i:s'),                    'content' => '-'.$data['number'],                    'unit' => '元',                    'type' => 'wallet',                    'describe' => static::getDescribe($data['type'], $data['note'] ?? '我的现金帐户' ),                ]);            }            return true;        } else {            return false;        }    }}