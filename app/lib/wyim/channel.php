<?php
namespace lib\wyim;
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
    private static function getList($pnum) {
        static::$url =  'https://vcloud.163.com/app/channellist';
        $data = array(
            'records' => 50,
            'pnum' => $pnum,
        );
        $result = static::sendJson($data);
        return $result ? $result->ret->list : false;
    }

    //刷新列表
    public static function refurbish()
    {
        set_time_limit(0);
        $pnum = 1;
        $cache = Yii::$app->redis;
        while(true)
        {
            $rst = static::getList($pnum);

            if(!$rst) {
                break;
            }

            foreach($rst as $key => $row) {
                $cacheData = json_encode(['status' => $row->status]);
                $cache->set(static::LIST_CACHE.$row->cid, $cacheData);
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

}