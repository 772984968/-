<?phpnamespace lib\nodes;//通知消息use lib\wyim\wyim;class Notice{    public static function send($to,$data)    {        return wyim::sendNotice([            'from' => '13043434556',            'msgtype' => '0',            'to' => $to,            'attach' => json_encode($data)        ]);    }}/*[    'title' => '充值成功',    'time' => date('Y-m-d H:i:s'),    'content' => '1000钻石',    'describe' => ['付款帐户:联联平台','交易对象:我的现金帐户']]*/?>