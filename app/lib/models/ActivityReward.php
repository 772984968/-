<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_activity_reward".
 *
 * @property integer $iid
 * @property string $name
 * @property string $event
 * @property string $parameter
 * @property string $rewardType
 * @property string $rewardNumber
 * @property string $s_dt
 * @property string $e_dt
 * @property integer $vip
 * @property integer $number_of_times
 * @property string $ refresh_time
 */
class ActivityReward extends \yii\db\ActiveRecord
{
    public static $userModel;
    const USER_ACTIVITY_STATUS_CACHE = 'user_activity_status_cache';
    const USER_ACTIVITY_REWARD_STATUS = 'user_activity_reward_status';
    private static $error_meaning= [
        1 => '已达到了领奖次数限制',
        2 => '非会员无法领取奖励',
        3 => '活动还未开始',
        4 => '活动已结束',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_activity_reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rewardType'], 'string'],
            [['rewardNumber'], 'number'],
            [['s_dt', 'e_dt', ' refresh_time'], 'safe'],
            [['vip', 'number_of_times'], 'integer'],
            [['name'], 'string', 'max' => 15],
            [['event'], 'string', 'max' => 20],
            [['parameter'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'name' => 'Name',
            'event' => 'Event',
            'parameter' => 'Parameter',
            'rewardType' => 'Reward Type',
            'rewardNumber' => 'Reward Number',
            's_dt' => 'S Dt',
            'e_dt' => 'E Dt',
            'vip' => 'Vip',
            'number_of_times' => 'Number Of Times',
            ' refresh_time' => 'Refresh Time',
        ];
    }

    //获取奖励
    public static function get($event, $parameter='')
    {
        $method = 'execute_'.$event;
        if(method_exists(__CLASS__,$method)) {
            return static::$method($parameter);
        } else {
            throw new \Exception('方法不存在');
        }
    }

    //激活奖励
    public static function activation($event, $parameter='') {
        $method = 'activation_'.$event;
        if(method_exists(__CLASS__,$method)) {
            return static::$method($parameter);
        } else {
            throw new \Exception('活动不存在');
        }

    }

    //获取，注册奖励
    public static function execute_register($parameter) {

        $activitys = static::getActivityRows('register'); //取直活动

        foreach ($activitys as $row) {

            $check_rst = static::checkBaseInfo($row);        //检查通用的要求

            if($check_rst !== true) {
                continue;
            }

            static::reward($row);
        }

    }

    //获取，观看直播奖励
    public static function execute_watch_live($parameter)
    {
        //取激活礼物的ID
        $activity_id = static::getActivity('watch_live');
        if(!$activity_id) {
            throw new \Exception('没有激活的宝箱可以打开');
        }

        //取活动数据
        $row = static::findOne($activity_id)->toArray();

        $check_rst = static::checkBaseInfo($row);
        if($check_rst !== true) {
            //检测未通过
            $rst[] = ['a_id'=>$row['iid'], 'rst'=>static::$error_meaning[$check_rst] ?? ''] ;;

        }elseif(static::reward($row)) {
            //领取成功
           \lib\wyim\chatroom::cacheUserIntoTime(static::$userModel->iid);  //刷新用户进入时间
           static::clearActivity('watch_live');     //消除缓存的礼物
            $rst[] = ['a_id'=>$row['iid'], 'rst'=> 'ok'] ;;

       } else {
            $rst[] = ['a_id'=>$row['iid'], 'rst'=> '领取失败'] ;;
       }
        return $rst;
    }

    //激活，观看直播奖励
    public static function activation_watch_live($parameter)
    {

        if(static::getActivity('watch_live')) {
            throw new \Exception('有激活的宝箱还未打开');
        }

        //取用户进入直播时间
        $into_time = \lib\wyim\chatroom::getUserIntoTime(static::$userModel->iid);

        if(!$into_time) {
            throw new \Exception('请先进入直播间,观看直播');
        }

        $time = $user_time = time() - $into_time;           //计算观看时长
        $activitys = static::getActivityRows('watch_live'); //取直播间活动

        $rst = [];
        foreach ($activitys as $row) {

            $a_parameter = $row['parameter'];
            $check_rst = static::activationCheckBaseInfo($row);        //检查通用的要求

            if($check_rst !== true) {
                $rst[] = ['a_id'=>$row['iid'], 'rst'=>static::$error_meaning[$check_rst] ?? ''] ;
                continue;
            }

            //检查这项活动特有的要求
            if($time<$a_parameter->duration) {
                $rst[] = ['a_id'=>$row['iid'], 'rst'=>'时间不够'.$a_parameter->duration.'秒不能激活'] ;
                break;
            }

            if(static::activity($row)) {
                $rst[] = ['a_id'=>$row['iid'], 'rst'=>'ok'] ;
                break;
            } else {
                $rst[$row['iid']] = $rst[] = ['a_id'=>$row['iid'], 'rst'=>'激活失败'] ;;
                break;
            }
        }
        return $rst;
    }


    //取活动的所有行
    public static function getActivityRows($name)
    {
        $data = static::find()
            ->where(['event'=>$name])
            ->orderBy('iid ASC')
            ->asArray()
            ->all();
        foreach($data as $key => $val) {
            $data[$key]['parameter'] = json_decode($val['parameter']);
        }
        return $data;
    }

    //检测通用信息
    private static function checkBaseInfo($row)
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

    //激活检测
    private static function activationCheckBaseInfo($row)
    {
        //检测领取次数
        $number = static::getstatus($row);

        if($number >= $row['number_of_times']) { //达到了上领取上限
            return 1;
        }

        if(strtotime($row['s_dt'])>time()) {
            return 3;
        }

        if( $row['e_dt']<date('Y-m-d H:i:s', time()) ) {
            return 4;
        }

        return true;

    }

    //激活礼物
    private static function activity($row) {
        return Yii::$app->redis->HSET(static::USER_ACTIVITY_REWARD_STATUS.static::$userModel->iid, $row['event'],$row['iid']);
    }

    //取礼物激活状态
    public static function getActivity($event) {
        return Yii::$app->redis->HGET(static::USER_ACTIVITY_REWARD_STATUS.static::$userModel->iid, $event);
    }

    //删除激活
    private static function clearActivity($event)
    {
        return Yii::$app->redis->HDEL(static::USER_ACTIVITY_REWARD_STATUS.static::$userModel->iid, $event);
    }

    //拿取活动奖励
    private static function reward($row) {
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
                break;
            default:
                $t->rollBack();
                return false;

        }
        $rst = static::changestatus($row);
        if($rst) {
            $t->commit();
            return true;
        } else {
            $t->rollBack();
            return false;
        }
    }

    //取用户活动状态
    public static function getstatus($activity) {
        $rst = Yii::$app->redis->hget(static::USER_ACTIVITY_STATUS_CACHE.static::$userModel->iid, $activity['event'].$activity['iid']);
        return $rst ?? '0';
    }

    //修改用户活动状态
    public static function changestatus($activity) {
        return Yii::$app->redis->hincrby(static::USER_ACTIVITY_STATUS_CACHE.static::$userModel->iid, $activity['event'].$activity['iid'],1);
    }

    //取一个活动所有的状态
    public static function getActivityStatus($type) {
        $activitys = static::getActivityRows($type);
        $newdata = [];
        foreach($activitys as $activity){
            $newdata[$activity['iid']] = static::getstatus($activity);
        }
        return $newdata;
    }
}
