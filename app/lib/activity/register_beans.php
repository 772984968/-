<?php
namespace lib\activity;
class register_beans extends activity
{
    public static function join($row)
    {
        $check_rst = static::checkBaseInfo($row);        //检查通用的要求
        if($check_rst !== true) {
          
        }
        static::reward($row);
    }



}
