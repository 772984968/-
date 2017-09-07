<?phpnamespace lib\forms;use Yii;use lib\models\User;use yii\extend\AdCommon;//提现表单class TransferAccountsForm extends CaptchaForm{    public $iid;    public $user_id;    public $accounts;    public $number;    public function scenarios()    {        return [            'transfer' => [                'user_id',                'accounts',                'number',            ],        ];    }    public function rules()    {        return [            [['iid', 'user_id', 'accounts', 'number'], 'required'],            ['number','number'],            ['number', 'compare', 'compareValue' => 0, 'operator' => '>'],        ];    }    public function attributeLabels()    {        return [        ];    }    public function transfer()    {        if($this->validate())        {            if(AdCommon::isMobile($this->accounts)) {                $targetModel = User::findByUsername($this->accounts);            } else {                $targetModel = User::findByLlaccounts($this->accounts);            }            if(!$targetModel) {                $this->addError('iid', '帐号不存在请重新输入');                return false;            }            if($targetModel->iid == $this->user_id) {                $this->addError('iid', '不能转帐给自己');                return false;            }            $userModel = User::findOne($this->user_id);            $t = Yii::$app->getDb()->beginTransaction();            $walletClass = Yii::$app->factory->getwealth('wallet', $userModel);            if(!$walletClass->sub([                'number' => $this->number,                'type' => \Config::WALLET_TRANSFER,                'source_user_id' => $targetModel->iid,                'note' => $this->accounts,            ])) {                $t->rollBack();                $this->addError('iid', $walletClass->error);                return false;            }            if(!Yii::$app->factory->getwealth('wallet', $targetModel)->add([                'number' => $this->number,                'type' => \Config::WALLET_TRANSFER,                'source_user_id' => $userModel->iid,                'note' => $userModel->username,            ])) {                $t->rollBack();                $this->addError('iid', '转帐失败');                return false;            }            $t->commit();            return true;        }    }    //创建定单号    private function createSn()    {        return time().mt_rand(1000,9999).$this->user_id;    }}