<?phpnamespace lib\channel;use lib\models\User;use Yii;use lib\wyim\channel;//直播排行class liveTelecastRanking{    const LIST_CACHE = 'live_Telecast_Ranking_list';    public static function addDiamond($user_id, $number)    {        rankingHour::addDiamond($user_id, $number);        rankingDay::addDiamond($user_id, $number);        rankingWeek::addDiamond($user_id, $number);        rankingMonth::addDiamond($user_id, $number);        matchRanking::addDiamond($user_id, $number);        ranking::addDiamond($user_id, $number);    }    public static function getGrade($user_id)    {        return matchRanking::getGrade($user_id) ?: ranking::getGrade($user_id);    }    //取联联人气列表，包含，状态，和人气    public static function getHotlist()    {        $newData = Yii::$app->getCache()->get(static::LIST_CACHE.'_hot');        if(!$newData) {            $data = \lib\models\Channel::find()                ->with('userinfo')                ->asArray()                ->all();            $newData = static::order($data);            Yii::$app->getCache()->set(static::LIST_CACHE.'_hot', $newData, 60);        }        return $newData;    }    //取联联比赛列表，包含，状态，和人气    public static function getMatchlist()    {        $newData = Yii::$app->getCache()->get(static::LIST_CACHE.'_match');        if(!$newData)        {            $data = \lib\models\Channel::find()                ->select('at_channel.*')                ->innerJoin('info','at_channel.user_id=info.uid')                ->with('userinfo')                ->asArray()                ->all();            $newData = static::order($data);            Yii::$app->getCache()->set(static::LIST_CACHE.'_match', $newData, 60);        }        return $newData;    }    //直播排序    private static function order($data)    {        $newData = [];        if($data)        {            //加上状态，和人气值            foreach($data as $key => $row)            {                $row['status'] = channel::getStatus($row['cid']);                $row['grade'] = \lib\channel\liveTelecastRanking::getGrade($row['user_id']);                $data[$key] = $row;            }            //把数据进行排序            $ranking = 1;            while($data)            {                $best = ['grade'=>0, 'status'=>0, 'key'=>0];                foreach($data as $key => $row) {                    if( ($row['status']> $best['status']) || ($row['status']>= $best['status'] && $row['grade']>=$best['grade']))                    {                        $best['grade'] = $row['grade'];                        $best['status'] = $row['status'];                        $best['key'] = $key;                    }                }                $selectRow = $data[$best['key']];                $selectRow['ranking'] = $ranking;                $ranking++;                $newData[] = $selectRow;                unset($data[$best['key']]);            }            //把数据进行缓存            Yii::$app->getCache()->set(static::LIST_CACHE, $newData, 60);        }        return $newData;    }    //载入15个到排行版中    public static function load($number = 15) {        $users = User::find()->limit($number)->asArray()->all();        foreach($users as $user) {            rankingHour::addDiamond($user['iid'], 0);            rankingDay::addDiamond($user['iid'], 0);            rankingWeek::addDiamond($user['iid'], 0);            rankingMonth::addDiamond($user['iid'], 0);            ranking::addDiamond($user['iid'], 0);        }    }    //取热门的排行列表    public static function hotlist($ranking=0, $limit=15)    {        $hotlist = static::getHotlist();        return array_slice($hotlist, $ranking, $limit);    }    //取比赛的排行列表    public static function matchlist($ranking=0, $limit=15)    {        $matchlist = static::getMatchlist();        return array_slice($matchlist, $ranking, $limit);    }    //取关注人的列表    public static function followlist($ranking=0, $user_id, $limit=15)    {        $hotlist = static::getHotlist();        //取关注人的ID        $ids = \lib\models\Fans::followIds($user_id);        $count = count($hotlist);        if(!$ids || $ranking>$count) {            return [];        }        $data = [];        $number = 0;        for($i=$ranking; $i<$count; $i++)        {            if(in_array($hotlist[$i]['user_id'], $ids)) {                $data[] = $hotlist[$i];                $number++;                if($number>=$limit) {                    break;                }            }        }        return $data;    }}