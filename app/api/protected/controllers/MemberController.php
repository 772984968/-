<?phpnamespace api\controllers;use Yii;use lib\models\Member;use lib\models\User;//会员控制器class MemberController extends BasisController{    //可购买的会员列表    public function actionList()    {        $result = Member::getCacheList();        foreach( $result as $key => $row ) {            unset( $row['operates'] );            unset( $row['is_default'] );            $result[$key] = $row;        }        $this->success(['list' => $result]);    }    //我的财富    public function actionWallet()    {        $user_id = Yii::$app->factory->getuser()->userId;        $userModel = \lib\models\User::findOne($user_id);        $this->success([            'wallet' => $userModel->wallet,            'diamond' => $userModel->diamond,            'count' => (string)(number_format($userModel->wallet + $userModel->diamond / \lib\models\Setting::keyTovalue('money2diamond') * 100,2)),        ]);    }    //余额转钻石    public function actionMoney2diamond(){        $number = intval(Yii::$app->getRequest()->post('number'));        $userModel = User::findOne(Yii::$app->factory->getuser()->userId);        $walletClass = Yii::$app->factory->getwealth('wallet', $userModel);        if($walletClass->toDiamond($number)) {            $this->success();        } else {            $this->error($walletClass->error);        }    }    //钻石转余额    public function actionDiamond2money(){        $number = intval(Yii::$app->getRequest()->post('number'));        $userModel = User::findOne(Yii::$app->factory->getuser()->userId);        $diamondClass = Yii::$app->factory->getwealth('diamond', $userModel);        if($diamondClass->toWallet($number)) {            $this->success();        } else {            $this->error($diamondClass->error);        }    }    //提现    public function actionWithdrawDeposit() {        parent::baseAction('\lib\forms\WithdrawDepositForm', 'apply');    }    //转帐    public function actionTransferAccounts() {        parent::baseAction('\lib\forms\TransferAccountsForm', 'transfer');    }    //帐单    public function actionBill(){        $billClass = new \lib\nodes\Bill();        $billClass->user_id = Yii::$app->factory->getuser()->userId;        $billClass->nextpage = (bool)Yii::$app->getRequest()->post('isnext');        $this->success(['list' => $billClass->list() ]);    }}