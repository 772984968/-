<?php
namespace lib\wyim;
use lib\vendor\imagine\Filter\Basic\Paste;
use Yii;

class channel extends wy
{
    const LIST_CACHE = 'wy_channel_list_cache';

    //设置录制视频回调地址
    public static  function setcallback(){
        static::$url = 'https://vcloud.163.com/app/record/setcallback';
        $data = array(
            'recordClk'=>'http://appapi.atkj6666.com/channel/livecallback',
        );
        $result = static::sendJson($data);
        return $result;
    }
    //设置录制视频回调地址查询
    public static  function callbackQuery(){
        static::$url = 'https://vcloud.163.com/app/record/callbackQuery';
        $data = array();
        $result = static::sendJson($data);
        return $result;
    }
    //缓存直播列表
    public static  function vedioList($cid,$records=10,$pum=1){
        static::$url = 'https://vcloud.163.com/app/videolist';
        $data = array(
            'cid'=>$cid,
            'records' => $records,
            'pum' => 1,
        );
        $result = static::sendJson($data);
        return $result;


    }

    //缓存直播
    public  static  function cacheLive($cid,$needRecord){
        static::$url='https://vcloud.163.com/app/channel/setAlwaysRecord';
        $data=[
            'cid'=>$cid,
            'needRecord'=>$needRecord,//1开启录制，0关闭录制
            'format'=>1,//格式1flv,0mp4
            'duration'=>30,//切片大小
        ];
        $result=static::sendJson($data);
        return $result;
    }
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

    /**
     *
     * @查询直播文件保存状态
     */
    public static  function getlivesave($cid){

        static::$url ='https://vcloud.163.com/app/channelstats';
        $data = array(
            'cid' => $cid
        );
        $result = static::sendJson($data);
     //   return $result->ret;
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

    //结束直播
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

}