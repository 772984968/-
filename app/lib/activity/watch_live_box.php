<?phpnamespace lib\activity;use lib\models\ActivityReward;use lib\models\ActivityDetailed;use Yii;class watch_live_box extends activity{    const USER_ACTIVITY_REWARD_STATUS = 'user_activity_reward_status';    public static function join($row, $parameter=''){        //取激活礼物的ID        $activity_id = static::getActivity($row['event']);        if(!$activity_id) {            throw new \Exception('没有激活的宝箱可以打开');        }        //取活动数据        $row = ActivityDetailed::findOne($activity_id)->toArray();        $check_rst = static::checkBaseInfo($row);        if($check_rst !== true) {            //检测未通过            $rst[] = ['a_id'=>$row['iid'], 'rst'=>static::$error_meaning[$check_rst] ?? ''] ;;        }elseif(static::reward($row)) {            //领取成功            \lib\wyim\chatroom::cacheUserIntoTime(static::$userModel->iid);  //刷新用户进入时间            static::clearActivity(static::$userModel->iid);     //消除缓存的礼物            $rst[] = ['a_id'=>$row['iid'], 'rst'=> 'ok'] ;;        } else {            $rst[] = ['a_id'=>$row['iid'], 'rst'=> '领取失败'] ;;        }        return $rst;    }    //刷新缓存    public static function refurbish()    {        $row = ActivityReward::findOne(2);        if(!$row) {            return false;        }        $row->toArray();        if( $row['refresh_time'] && date('H',time())==date('H',strtotime($row['refresh_time'])) ) {            $activitys = ActivityDetailed::getTypeRows($row['iid']);            if($activitys)            {                //取出所有活动                static::refurbish_jh($activitys);           //消除激活状态                static::refurbish_status($activitys);       //消除活动状态            }        }    }    //激活，观看直播奖励    public static function activation($c_id)    {        if(static::getActivity($c_id)) {            throw new \Exception('有激活的宝箱还未打开');        }        //取用户进入直播时间        $into_time = \lib\wyim\chatroom::getUserIntoTime(static::$userModel->iid);        if(!$into_time) {            throw new \Exception('请先进入直播间,观看直播');        }        $time = $user_time = time() - $into_time;                       //计算观看时长        $activitys = ActivityDetailed::getTypeRows($c_id);        //取直播间活动        $rst = [];        foreach ($activitys as $row) {            $a_parameter = $row['parameter'];            $check_rst = static::activationCheckBaseInfo($row);        //检查通用的要求            if($check_rst !== true) {                $rst[] = ['a_id'=>$row['iid'], 'rst'=>static::$error_meaning[$check_rst] ?? ''] ;                continue;            }            //检查这项活动特有的要求            if($time<$a_parameter->duration) {                $rst[] = ['a_id'=>$row['iid'], 'rst'=>'时间不够'.$a_parameter->duration.'秒不能激活'] ;                break;            }            if(static::activity($row)) {                $rst[] = ['a_id'=>$row['iid'], 'rst'=>'ok'] ;                break;            } else {                $rst[$row['iid']] = $rst[] = ['a_id'=>$row['iid'], 'rst'=>'激活失败'] ;;                break;            }        }        return $rst;    }    //激活检测    private static function activationCheckBaseInfo($row)    {        //检测领取次数        $number = static::getstatus($row);        if($number >= $row['number_of_times']) { //达到了上领取上限            return 1;        }        return true;    }    //激活礼物    private static function activity($row) {        return Yii::$app->redis->set(static::USER_ACTIVITY_REWARD_STATUS.static::$userModel->iid, $row['iid']);    }    //取被激活的礼物    private static function getActivity() {        return Yii::$app->redis->get(static::USER_ACTIVITY_REWARD_STATUS.static::$userModel->iid);    }    //消除激活的状态    private static function clearActivity($user_id)    {        $user_id = $user_id ? $user_id : static::$userModel->iid;        return Yii::$app->redis->expire(static::USER_ACTIVITY_REWARD_STATUS.$user_id, -1);    }    //消除所有激活的宝箱    private static function refurbish_jh(&$activitys)    {        $redis = Yii::$app->redis;        //取出所有 ‘领取记录键’        $keys = $redis->keys(static::USER_ACTIVITY_REWARD_STATUS.'*');        $start = strlen(static::USER_ACTIVITY_REWARD_STATUS);        foreach($keys as $key)        {            $user_id = substr($key,$start);            static::clearActivity($user_id);        }    }}