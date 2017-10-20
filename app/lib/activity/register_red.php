<?php
namespace lib\activity;

use lib\wealth\RedEnvelope;
use lib\models\User;
use lib\models\ActivityDetailed;

class register_red extends activity
{

    /**
     * 注册红包活动类
     */
    const USER_RED_PERSON = 'user_red_person'; // 用户活动状态缓存
    const USER_RED_ALL = 'user_red__all'; // 领取红包的所有用户


    public static function join($row='',$parameter='',$call_back='')
    {


        if ($parameter['sharing']=='sharing'){
        $data = ActivityDetailed::getTypeRows($row['iid']);
        foreach($data as $drow)
        {
            $check_rst = static::checkBaseInfo($drow);        //检查通用的要求
            if($check_rst !== true) {
                return false;
            }
        }
            $RedModel = new RedEnvelope();
            $userModel = User::findOne([
            'username' => activity::$userModel->inviteCode
            ]);
            if (! $userModel)
            return false;
            $RedModel->userModel = $userModel;
            $transaction = \Yii::$app->getDb()->beginTransaction();
            try {
                if (!$RedModel->toWallet($drow['rewardNumber'],'红包转换为余额'))
                    throw new \Exception();
                if (! static::changestatus($drow))
                    throw new \Exception();
                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }
        return false;
    }
    // 添加已领取用户
    public static function changestatus($drow)
    {
        \Yii::$app->redis->sadd(static::USER_RED_ALL, static::USER_RED_PERSON . activity::$userModel->iid);
        return true;
    }
    //清空已领取总领取人数
    public static function clearnums()
    {
           \Yii::$app->redis->del(static::USER_RED_ALL);
            return true;
    }
    //返回已领取人数
    public static function user_red_all()
    {
        return \Yii::$app->redis->scard(static::USER_RED_ALL);
    }
}
