<?phpclass Config{    //添加好友信息    const SEND_ADD_BUDDY = 1;    const RECEIVE_ADD_BUDDY = 2;    //钱包    const WALLET_VIP = 10001;               //购买VIP 推荐人奖励    const WALLET_RECHARGE = 10002;          //充值    const WALLET_CHANGE_DIAMOND = 10003;    //钻石转余额    const WALLET_AGENT_VIP  = 10005;        //代理VIP    const WALLET_WITHDRAW_DEPOSIT = 10008;  //提现    const WALLET_TRANSFER = 10009;          //转帐    //钻石    const DIAMOND_CHANGE_WALLET = 20004;    //余额转钻石    const DIAMOND_RECHARGE_RECOMMEND = 20007;   //充值，推荐人奖励    const DIAMOND_RECHARGE_AGENT = 20006;   //充值，代理奖励    //钱包意义    public static function walletLogMeaning()    {        return [            '10001' => '推荐奖励',            '10002' => '充值-现金',            '10003' => '钻石转余额',            '10005' => '代理奖励',            '10008' => '提现-现金',            '10009' => '转帐-现金',            '20002' => '余额转钻石',            '20004' => '余额转钻石',            '20007' => '推荐奖励',            '20006' => '代理奖励',        ];    }    //信息类型意义    public static function typeMeaning()    {        return [            1 => '请求添加好友',            2 => '请求添加好友',        ];    }}