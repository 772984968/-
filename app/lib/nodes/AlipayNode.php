<?php
namespace lib\nodes;
use yii\extend\AdCommon;
use Yii;
use yii\aop\AopClient;
use yii\aop\request\AlipayTradeAppPayRequest;
use yii\aop\request\AlipayFundTransToaccountTransferRequest;
class AlipayNode extends \yii\base\Component
{
    /**
     * 签名订单信息
     * @param $orderinfo
     * orderinfo [
     *      body => 说明
     *      subject => 标题
     *      out_trade_no => 订单号
     *      total_amount => 金额
     * ]
     */
    public static function signorder($bizcontent)
    {
        $aop = new AopClient;
        //$aop->rsaPrivateKey = 'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAPC79BeZ+aJszhSNz7O7tmp7u5dfolB+YmvqyatxNDC6zsmuauZpeO+oAaVS8uVXR+zV5nLLLfqiEDP6Hfqu9l2TQB5sxhulPT9/Q9mi5KzUev2ehgWHo+gVD/0GJUGhO9uJiCrx5b3bzoavftyIwq0lmt4lpF5bHUZO+eE9QQEFAgMBAAECgYEAlomSLCgXGODdRbEgTw51FcVmG1SsVZWSylU540GZF1fZ8/hj1M3j2EnBLbbfOVcJHSrtPp+bkv1BEJ+5m4dJeygb9fOG49kKP0jr1iJxVR/R9ZIHJzUWqGm21hhTGzgz76rVmO5HAEECxT8NPY10uH9k38WBhy3u75W88QEcpEkCQQD5gbIb+Nl46hSyJayEPZRpJyUMyBuM1FwatiOZ0mg9D8C1QNqkqlPvbUemt2CDfHJjewdSunTmAp5s9BCPgwZnAkEA9v/QBxxx4q0kT1dGx3pVqqlnYVNp2NeiEFGhQjBSEXwGcqXqEeOuvH/KbEw4zWcTHcqj37YSsEvurZwuBAXhswJAUsQ/PSAzo/SioOX2cHes/6TImZDX8sOPOh0peiFeCsNq/bVh0jXeWhI6LoeuMG/b0jxBlaPcm2BLBYGA7NpeCQJBANPW8wQmUUaoWMvzfrD3KyIDyLagY9emmUiFuliaOMjmJmGOCwLs06C3uVTIyq7gCHU0pvfnoH+zoDEmEhFBOiECQAkQP+ZI+mXbZdchrof1afzHzFG4gIF9PmkP4wqR+i1J8CZ2z9y8CJRDFZjAIp5I+kZ71gonfmJu4DoqxkoqG6U=';
        //$aop->alipayrsaPublicKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB';
        //$aop->format = "json";
        //$aop->charset = "UTF-8";
        //$aop->signType = "RSA";
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new AlipayTradeAppPayRequest();
//SDK已经封装掉了公共参数，这里只需要传入业务参数
        $request->setNotifyUrl("http://appapi.atkj6666.cn/order/ali");
        $request->setBizContent($bizcontent);
//这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
//htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        return htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
    }

    public static function transferAccounts($bizcontent) {
        $aop = new AopClient;

        $request = new AlipayFundTransToaccountTransferRequest();

        $request->setBizContent($bizcontent);

        $result = $aop->execute ( $request );

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

        $resultCode = $result->$responseNode->code;
        
        if(!empty($resultCode)&&$resultCode == 10000){
            return true;
        } else {
            return $result->$responseNode->sub_msg ?? '';
        }
    }
    
    


}


?>