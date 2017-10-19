<?php
namespace lib\activity;

class activity
{
    public static $userModel;

    protected static $error_meaning= [
        1 => '已达到了领奖次数限制',
        2 => '非会员无法领取奖励',
        3 => '活动还未开始',
        4 => '活动已结束',
    ];

    public static function join(){

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

        if(strtotime($row['s_dt'])>time()) {
            return 3;
        }

        if( $row['e_dt']<date('Y-m-d H:i:s', time()) ) {
            return 4;
        }

        return true;

    }

    //拿取活动奖励
    protected static function reward($row) {
        $t = Yii::$app->getDb()->beginTransaction();
        switch ($row['rewardType'])
        {
            case 'beans':
                if(!Yii::$app->factory->getwealth('beans', static::$userModel)->add([
                'number' => $row['rewardNumber'],
                'type' => \Config::BEANS_ACTIVITY,
                'note' => $row['name'],
                ])) {
                    $t->rollBack();
                    return false;
                }
                \lib\nodes\UserMessage::sendBeans(static::$userModel->iid, 'regiser', $row['rewardNumber']);
                break;
            case 'wallet':
                if(!Yii::$app->factory->getwealth('wallet', static::$userModel)->add([
                'number' => $row['rewardNumber'],
                'type' => \Config::BEANS_ACTIVITY,
                'note' => $row['name'],
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

}
?>