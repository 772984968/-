<?php
namespace lib\nodes;
use Yii;
/**
 * Class UserMessage
 * @package lib\nodes
 * 系统给用户发送的信息存放在这里，
 * 客户端登入后，获取这里的数据，告知客户，
 * 信息，获取后消失
 *
 * 数据后进后出
 */
class UserMessage
{
    const CACHE_NAME = 'atapp_lib_nodes_user_message_';
    //加入一条信息
    public static function send($user_id, $data)
    {
        return Yii::$app->redis->rpush(static::CACHE_NAME.$user_id, json_encode($data));
    }

    public static function sendBeans($user_id,$event,$number)
    {
        return static::send($user_id,[
            'event' => $event,
            'type' => 'beans',
            'number' => (string)$number,
        ]);
    }



    //取一条最原始的数据
    public static function get($user_id)
    {
        $rst = Yii::$app->redis->lpop(static::CACHE_NAME.$user_id);
        if($rst) {
            $rst = json_decode($rst);
        }
        return $rst;
    }



    //取该用户所有的数据
    public static function getall($user_id)
    {
        $data = [];
        do{
            $rst = static::get($user_id);
            if($rst) {
                $data[] = $rst;
            }
        }while($rst);
        return $data;

    }
}