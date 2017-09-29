<?phpnamespace lib\channel;use Yii;//比赛排行class matchRanking extends ranking{    protected static $name = 'match_ranking';    //添加钻石    public static function addDiamond($user_id, $number)    {        $redis = Yii::$app->redis;        //存在才添加        $result = $redis->zscore(static::$name, $user_id);        if(!is_null($result)) {            return $redis->zincrby(static::$name, $number*10, $user_id);        }        return 0;    }    //添加关注    public static function addFollow($user_id)    {        $redis = Yii::$app->redis;        $result = $redis->zscore(static::$name, $user_id);        if(!is_null($result)) {            return $redis->zincrby(static::$name, 100, $user_id);        }        return 0;    }    //减少关注    public static function subFollow($user_id)    {        $redis = Yii::$app->redis;        $result = $redis->zscore(static::$name, $user_id);        if(!is_null($result)) {            return $redis->zincrby(static::$name, -100, $user_id);        }        return 0;    }    //把所有比赛用户加入到比赛中    public static function load($number=10)    {        $redis = Yii::$app->redis;        $count = $redis->zcount(static::$name, 0, -1);        if($count == 0)        {            $data = Yii::$app->getDb()->createCommand("SELECT u.iid,u.follow_number FROM at_user as u RIGHT JOIN info ON u.iid=info.uid")->queryAll();            foreach($data as $row) {                $redis->zadd(static::$name, 100*$row['follow_number']+1, $row['iid']);            }        }    }    //检测用户是否参加了比赛    public static function is_takepart($user_id)    {        return Yii::$app->redis->zscore(static::$name, $user_id);    }    //检测用户是否参加了比赛    public static function in_takepart($user_id)    {        return Yii::$app->redis->zscore(static::$name, $user_id);    }    //检测用户是否参加了比赛    public static function add_takepart($user_id)    {        $data = Yii::$app->getDb()->createCommand("SELECT u.iid,u.follow_number FROM at_user as u RIGHT JOIN info ON u.iid=info.uid where u.iid='$user_id'")->queryOne();        if($data && !static::in_takepart($user_id)) {            Yii::$app->redis->zadd(static::$name, 100*$data['follow_number']+1, $data['iid']);        }    }        //把这位用户加入到比赛中    public static function addUser($user_id) {        $redis = Yii::$app->redis;        $count = $redis->zcount(static::$name, 0, -1);        if($count == 0)        {            $row = Yii::$app->getDb()->createCommand("SELECT u.iid,u.follow_number FROM at_user where iid=$user_id")->queryOne();            if($row) {                $redis->zadd(static::$name, 100*$row['follow_number'], $row['iid']);            }        }    }}