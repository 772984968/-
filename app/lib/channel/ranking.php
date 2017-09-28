<?phpnamespace lib\channel;use Yii;use lib\models\User;class ranking{    protected static $name = 'ran_king';    //添加钻石    public static function addDiamond($user_id, $number)    {        $redis = Yii::$app->redis;        return $redis->zincrby(static::$name, $number*10, $user_id);    }    //取列表    public static function list($user_id, $number = 10) {        $redis = Yii::$app->redis;        $data = $redis->zrevrange(static::$name, 0, $number, 'WITHSCORES');        $newdata = [];        if($data) {            while($data) {                $uid = array_shift($data);                $grade = array_shift($data);                $newdata[$uid] = $grade;            }            $ids = implode(',', array_keys($newdata));            $sql = "SELECT u.iid,head,nickname,vip_type,live_telecast_status,llaccounts,follow_number,fans_number,signature,f.iid AS mutual,c.cid,if(isnull(b.iid),0,1) AS buddy FROM at_user as u   LEFT JOIN at_fans AS f ON u.iid = f.user_id AND f.fans_id=$user_id LEFT JOIN at_channel AS c ON u.iid = c.user_id LEFT JOIN at_buddy as b ON b.user_id=u.iid AND b.buddy_id=$user_id WHERE u.iid IN($ids)";            $users = Yii::$app->getDb()->createCommand($sql)->queryAll();            foreach($users as $user) {                $user['head'] = \lib\nodes\UserNode::get_head_url($user['head']);                $user['live_telecast_status'] = \lib\wyim\channel::getStatus($user['cid']);                unset($user['cid']);                $user['mutual'] = $user['mutual'] ?? 0;                $user['grade'] = $newdata[$user['iid']];                $newdata[$user['iid']] = $user;            }            $newdata = array_values($newdata);            $newdata = array_filter($newdata);        }        return $newdata;    }    //消除数据    public static function clear()    {        $redis = Yii::$app->redis;        $data = $redis->zrevrange(static::$name, 0, -1);        foreach($data as $name) {            $redis->zadd(static::$name, 0, $name);        }    }    //取人气值    public static function getGrade($user_id)    {        $redis = Yii::$app->redis;        return $redis->zscore(static::$name, $user_id) ?? 0;    }}