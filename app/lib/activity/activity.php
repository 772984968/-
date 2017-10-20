<?php
namespace lib\activity;
use lib\models\ActivityDetailed;
use lib\models\ActivityReward;
use Yii;
class activity
{
    public static $userModel;
    const USER_ACTIVITY_STATUS_CACHE = 'user_activity_status_cache';
    protected static $error_meaning= [
        1 => '已达到了领奖次数限制',
        2 => '非会员无法领取奖励',
        3 => '活动还未开始',
        4 => '活动已经结束',
    ];


    public static function join($row, $parameter='', $call_back='' )
    {
        $data = ActivityDetailed::getTypeRows($row['iid']);
        foreach($data as $drow)
        {
            $check_rst = static::checkBaseInfo($drow);        //检查通用的要求
            if($check_rst !== true) {
                continue;
            }
            if(static::reward($drow)) {
                if($call_back) {
                    $method = $call_back['method'];
                    $call_back['class']::$method($drow, $parameter);
        }
                return true;
            } else {
                return false;
    }
        }
    }
    //刷新缓存状态
    public static function refurbish($a_id)
    {
        $row = ActivityReward::findOne($a_id);
        if(!$row) {
            return false;
    }
        $row->toArray();
        if( $row['refresh_time'] && date('H',time())==date('H',strtotime($row['refresh_time'])) ) {
            $data = ActivityDetailed::getTypeRows($a_id);
            if($data) {
                static::refurbish_status($data);
            }
        }
    }

    //检测通用信息
    protected static function checkBaseInfo($row)
    {
        //检测领取次数
        $number = static::getstatus($row);
        if($number >= $row['number_of_times']) { //达到了上领取上限
            return 1;
        }
        if($row['vip'] && !static::$userModel->vip_type) {
            return 2;
        }
        return true;

    }

    //拿取活动奖励
    protected static function reward($row) {
        $t = Yii::$app->getDb()->beginTransaction();
        switch ($row['rewardType'])
        {
            case 'beans':
                $beans_cls = Yii::$app->factory->getwealth('beans', static::$userModel);
                if(!$beans_cls->add([
                'number' => $row['rewardNumber'],
                'type' => \Config::BEANS_ACTIVITY,
                'note' => (string)$row['iid'],
                ])) {
                    $t->rollBack();
                    return false;
                }
                break;
            case 'wallet':
                if(!Yii::$app->factory->getwealth('wallet', static::$userModel)->add([
                'number' => $row['rewardNumber'],
                'type' => \Config::WALLET_ACTIVITY,
                'note' => (string)$row['iid'],
                ])) {
                    $t->rollBack();
                    return false;
                }
                break;
            default:
                $t->rollBack();
                return false;

        }
        //修改状态
        $rst = static::changestatus($row);
        if($rst) {
            $t->commit();
            return true;
        } else {
            $t->rollBack();
            return false;
        }
    }

    //取没有领取的活动
    public static function getUnused($a_id)
    {

        $data = ActivityDetailed::getTypeRows($a_id);
        foreach($data as $val) {
            if(static::getstatus($val) < $val['number_of_times']) {
                return $val;
            }
        }
        return json_decode('{}');
    }


    //取用户获得次数
    public static function getstatus($detailed) {
        $rst = Yii::$app->redis->hget(static::USER_ACTIVITY_STATUS_CACHE.static::$userModel->iid, $detailed['a_id'].':'.$detailed['iid']);
        return $rst ?? '0';
    }

    //用户获得次数加1
    public static function changestatus($detailed) {
        return Yii::$app->redis->hincrby(static::USER_ACTIVITY_STATUS_CACHE.static::$userModel->iid, $detailed['a_id'].':'.$detailed['iid'],1);
    }

    //消除用户获得次数
    public static function clearstatus($detailed,$user_id=0) {
        $user_id = $user_id ? $user_id : static::$userModel->iid;
        return Yii::$app->redis->hdel(static::USER_ACTIVITY_STATUS_CACHE.$user_id, $detailed['a_id'].':'.$detailed['iid']);
    }

    //重置活动状态
    public static function refurbish_status(&$detaileds)
    {
        $redis = Yii::$app->redis;
        //取出所有 ‘领取记录键’
        $keys = $redis->keys(static::USER_ACTIVITY_STATUS_CACHE.'*');
        $start = strlen(static::USER_ACTIVITY_STATUS_CACHE);

        foreach($keys as $key)
        {
            $user_id = substr($key,$start);
            foreach($detaileds as $detailed)
            {
                static::clearstatus($detailed, $user_id);
            }
        }
    }


}
?>

