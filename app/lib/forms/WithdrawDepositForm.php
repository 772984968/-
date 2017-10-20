<?phpnamespace lib\forms;use Yii;use lib\models\UserWithdrawDeposit;use lib\models\User;use yii\extend\AdCommon;//提现表单class WithdrawDepositForm extends CaptchaForm{    public $iid;    public $user_id;    public $ali_account;    public $ali_name;    public $number;    const STATUS_AGREE = 1;    public function scenarios()    {        return [            'apply' => [                'user_id',                'ali_account',                'ali_name',                'number',            ],        ];    }    public function rules()    {        return [            [['iid', 'ali_account', 'ali_name', 'number'], 'required'],            ['number', 'number'],            ['number', 'compare', 'compareValue' => 0, 'operator' => '>'],        ];    }    public function attributeLabels()    {        return [        ];    }    public function apply()    {        if($this->validate())        {            $userModel = User::findOne($this->user_id);            if(empty($userModel->vip_type)) {                throw new \Exception('非VIP不能提现');            }            $t = Yii::$app->getDb()->beginTransaction();            $walletClass =  Yii::$app->factory->getwealth('wallet', $userModel);            if(!$walletClass->sub([                'number' => $this->number,                'type' => \Config::WALLET_WITHDRAW_DEPOSIT,            ])) {                $this->addError('iid', $walletClass->error);                $t->rollBack();                return false;            }            //添加提现记录            $model = new UserWithdrawDeposit();            $model->attributes = AdCommon::array_clear_null($this->attributes);            $model->pay_sn = $this->createSn();            if(!$model->save()) {                $this->addError('iid', AdCommon::modelMessage($model->errors));                $t->rollBack();                return false;            }            $t->commit();            $bizcontent = "{\"out_biz_no\":\"{$model->pay_sn}\","                . "\"payee_type\": \"ALIPAY_LOGONID\","                . "\"payee_account\": \"{$this->ali_account}\","                . "\"amount\": \"{$this->number}\","                . "\"payee_real_name\": \"{$this->ali_name}\","                . "\"remark\":\"联联提现\""                . "}";            $result = \lib\nodes\AlipayNode::transferAccounts($bizcontent);            if($result !== true) {                $model->sendBack();                $this->addError('iid', $result);                return false;            }            $model->status = 1;            $model->save();            return true;        }    }    //创建定单号    private function createSn()    {        return time().mt_rand(1000,9999).$this->user_id;    }}