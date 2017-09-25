<?phpnamespace lib\channel;use Yii;use lib\models\User;abstract class ranking{    protected static $name;    //添加钻石    public static function addDiamond($user_id, $number)    {        $redis = Yii::$app->redis;        return $redis->zincrby(static::$name, $number*10, $user_id);    }    //取列表    public static function list($user_id, $number = 10) {        $redis = Yii::$app->redis;        $data = $redis->zrevrange(static::$name, 0, $number, 'WITHSCORES');        $newdata = [];        if($data) {            while($data) {                $uid = array_shift($data);                $grade = array_shift($data);                $newdata[$uid] = $grade;            }            $ids = implode(',', array_keys($newdata));            $sql = "SELECT u.iid,head,nickname,vip_type,live_telecast_status,f.iid AS mutual FROM at_user as u   LEFT JOIN at_fans AS f ON u.iid = f.user_id AND f.fans_id=$user_id WHERE u.iid IN($ids)";            $users = Yii::$app->getDb()->createCommand($sql)->queryAll();            foreach($users as $user) {                $user['head'] = User::get_head_url($user['head']);                $user['mutual'] = $user['mutual'] ?? 0;                $user['grade'] = $newdata[$user['iid']];                $newdata[$user['iid']] = $user;            }            $newdata = array_values($newdata);        }        return $newdata;    }    //消除数据    public static function clear()    {        $redis = Yii::$app->redis;        $data = $redis->zrevrange(static::$name, 0, -1);        foreach($data as $name) {            $redis->zadd(static::$name, 0, $name);        }    }}