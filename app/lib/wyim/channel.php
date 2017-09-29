<?php
namespace lib\wyim;
use lib\vendor\imagine\Filter\Basic\Paste;
use Yii;
class channel extends wy
{
    const LIST_CACHE = 'wy_channel_list_cache';

    //创建直播
    public static function createLiveRoom($name)
    {
        static::$url = 'https://vcloud.163.com/app/channel/create';
        $data = array(
            'name' => $name,
            'type' => 0,
        );
        $result = static::sendJson($data);
        return $result;
    }

    //更新直播
    public static function updateLiveRoom($cid, $name)
    {
        static::$url = 'https://vcloud.163.com/app/channel/update';
        $data = array(
            'name' => $name,
            'cid' => $cid,
            'type' => 0,
        );
        $result = static::sendJson($data);
        return $result;

    }

    //删除直播
    public static function deleteChanel($cid) {
        static::$url =  'https://vcloud.163.com/app/channel/delete';
        $data = array(
            'cid' => $cid,
        );
        $result = static::sendJson($data);
        static::deleteCache($cid);
        return $result;
    }

    //取网易直播列表数据
    public static function getList($pnum) {
        static::$url =  'https://vcloud.163.com/app/channellist';
        $data = array(
            'records' => 50,
            'pnum' => $pnum,
        );
        $result = static::sendJson($data);
        return $result ? $result->ret->list : false;
    }

    //取网易云直播状态
    public static function channelstats($cid)
    {
        static::$url =  'https://vcloud.163.com/app/channelstats';
        $data = array(
            'cid' => $cid
        );
        $result = static::sendJson($data);
        return $result ? $result->ret->status : false;

    }

    //刷新列表
    public static function refurbish()
    {
        set_time_limit(0);
        $pnum = 1;
        while(true)
        {
            $rst = static::getList($pnum);

            if(!$rst) {
                break;
            }

            foreach($rst as $key => $row) {
                static::changeStatus($row->cid, $row->status);
            }
            $pnum++;

        }

        //chatroom::refurbish();   //刷新聊天室人数

    }
    
    //取缓存在本机的直播信息
    public static function getinfo($cid)
    {
        if(!$cid) {
            return '';
        }
        $cache = Yii::$app->redis;
        return json_decode($cache->get(static::LIST_CACHE.$cid));
    }

    //删除缓存数据
    public static function deleteCache($cid) {
        $cache = Yii::$app->redis;
        $cache->expire(static::LIST_CACHE.$cid, -1);
    }

    //修改缓存直播状态
    public static function changeStatus($cid, $status) {
        $info = static::getinfo($cid) ?? [];

        if($info) {
            $info->status = $status;
        } else {
            $info['status'] = $status;
        }

        $cache = Yii::$app->redis;
        $cache->set(static::LIST_CACHE.$cid, json_encode($info));
    }

    //取直播状态
    public static function getStatus($cid)
    {
        $info = static::getinfo($cid);

        if(!$info) {
            $status = '0';
        } else {
           $status = (string)$info->status;
        }
        return $status;
    }

    //开始直播
    public static function begin($cid, $grade) {

        $info = static::getinfo($cid) ?? [];
        if($info) {
            $info->status = 1;
            $info->grade = $grade;
            $info->begin_time = time();
        } else {
            $info = [
                'status' => 1,
                'grade' => $grade,
                'begin_time' => time(),
            ];
        }
        Yii::$app->redis->set(static::LIST_CACHE.$cid, json_encode($info));
    }

    public static function finish($cid, $grade)
    {

        $info = static::getinfo($cid);
        static::changeStatus($cid, 0);
        $time = time()-$info->begin_time;
        $h = intval($time / 3600);
        $m = intval($time / 60);
        $s = $time % 60;

        $data =  [
            'duration'=>"$h:$m:$s",
            'onlineusercount' => chatroom::get_online_count($cid),
            'grade' => $grade - $info->grade,
        ];
        return $data;
    }

    //取联联比赛列表，包含，状态，和人气
    public static function getLLlist()
    {
        $newData = Yii::$app->getCache()->get(static::LIST_CACHE);
        if(!$newData)
        {
            $data = \lib\models\Channel::find()
                ->with('userinfo')
                ->asArray()
                ->all();

            $newData = [];
            if($data)
            {
                //加上状态，和人气值
                foreach($data as $key => $row)
                {
                    $row['status'] = channel::getStatus($row['cid']);
                    $row['grade'] = \lib\channel\liveTelecastRanking::getGrade($row['user_id']);
                    $data[$key] = $row;
                }

                //把数据进行排序

                while($data)
                {
                    $best = ['grade'=>0, 'status'=>0, 'key'=>0];
                    foreach($data as $key => $row) {
                        if($row['status']>= $best['status'] && $row['grade']>=$best['grade']) {
                            $best['grade'] = $row['grade'];
                            $best['status'] = $row['status'];
                            $best['key'] = $key;
                        }
                    }
                    $newData[] = $data[$best['key']];
                    unset($data[$best['key']]);
                }
                //把数据进行缓存
                Yii::$app->getCache()->set(static::LIST_CACHE, $newData, 60);
            }
        }
        return $newData;

    }

}