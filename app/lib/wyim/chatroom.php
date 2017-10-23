<?phpnamespace lib\wyim;use lib\models\User;use yii\extend\AdCommon;use Yii;class chatroom extends wy{    const CACHE_NAME = 'wy_chatroom_cache';    const USER_INTO_TIME_LIST = 'chat_room_user_into_time_';    //创建聊天室    public static function create($creator, $name)    {        static::$url = 'https://api.netease.im/nimserver/chatroom/create.action';        $result = static::send([            'creator' => $creator,            'name' => $name,        ]);        if($result) {            return $result->chatroom;        } else {            return false;        }    }    //发送聊天室信息    public static function sendGift($roomid, User $userModel, $result, $type='2')    {        static::$url = 'https://api.netease.im/nimserver/chatroom/sendMsg.action';        $msgId = md5(AdCommon::randomkeys().time().mt_rand());        $result = static::send([            'roomid' => $roomid,            'msgId' => $msgId,            'fromAccid' => '13043434556',            'msgType' => 0,            'ext' => json_encode([                'type'=>(string)$type,                'userinfo' => [                    'iid' => $userModel->iid,                    'nickname' => $userModel->nickname,                    'vip' => $userModel->vip_type ? '1' : '0',                    'head' => \lib\nodes\UserNode::get_head_url($userModel->head),                    'slogan' => $userModel->signature,                    'fanscount' => $userModel->fans_number,                    'concerncount' => $userModel->follow_number,                    'llaccount' => $userModel->llaccounts,                ],                'result' => $result            ]),        ]);        if($result) {            return true;        } else {            return false;        }    }    //取聊天室信息    public static function get($roomid)    {        static::$url = 'https://api.netease.im/nimserver/chatroom/get.action';        $result = static::send([            'roomid' => $roomid,            'needOnlineUserCount' => 'true',        ]);        if($result) {            return $result->chatroom;        } else {            return false;        }    }    //分页获取成员列表    /*public static function membersByPage($roomid)    {        static::$url = 'https://api.netease.im/nimserver/chatroom/membersByPage.action';        $result = static::send([            'roomid' => $roomid,            'type' => 0,            'endtime' => 0,            'limit' => 10,        ]);        if($result) {            return $result->desc->data;        } else {            return false;        }    }*/    //刷新列表   /* public static function refurbish()    {        $page = 1;        $psize = 60;        while(true)        {            $data = Channel::find()                ->select('cid,roomid')                ->offset(($page-1)*$psize)                ->limit($psize)                ->asArray()                ->all();            if(!$data) {                break;            }            $cache = Yii::$app->getCache();            foreach($data as $row) {                $members = static::membersByPage($row['roomid']);                $roominfo = static::get($row['roomid']);                if($roominfo)                {                    $cache->set(static::self::CACHE_NAME.$row['roomid'], ['onlineusercount'=>$roominfo->onlineusercount]);                }            }            //test            $page++;        }    }*/    //取缓存在本机的直播信息    public static function getinfo($cid)    {        $cache = Yii::$app->getCache();        return json_decode( $cache->get(static::CACHE_NAME.$cid) );    }    public static function setinfo($cid, $data) {        $cache = Yii::$app->getCache();        $cache->set(static::CACHE_NAME.$cid, json_encode($data));    }    public static function clearinfo($cid)    {        return Yii::$app->getCache()->delete(static::CACHE_NAME.$cid);    }    //缓存用户进入时间    public static function cacheUserIntoTime($uid){        \Yii::$app->getCache()->set(static::USER_INTO_TIME_LIST.$uid, time());    }    //取用户进入时间    public static function getUserIntoTime($uid) {        $time = \Yii::$app->getCache()->get(static::USER_INTO_TIME_LIST.$uid);        return $time;    }    public static function addUser($cid, $user_id)    {        $data = static::getinfo($cid);        if($data) {            $data->onlineusercount++;            $members = $data->members ?? [];            if(!in_array($user_id, $members)) {                    array_pop($members);            }            $data->members=$members;        } else {            $data = ['onlineusercount'=>1, 'members'=>[$user_id]];        }        static::cacheUserIntoTime($user_id);        static::setinfo($cid, $data);    }    public static function get_online_count($cid)    {        $data = static::getinfo($cid);        if($data) {            $count = $data->onlineusercount;        } else {            $count = 0;        }        return (string)$count;    }}