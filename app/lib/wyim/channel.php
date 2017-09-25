<?php
namespace lib\wyim;
class channel extends wy
{
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

    public static function deleteChanel($cid) {
        static::$url =  'https://vcloud.163.com/app/channel/delete';
        $data = array(
            'cid' => $cid,
        );
        $result = static::sendJson($data);
        return $result;
    }
}