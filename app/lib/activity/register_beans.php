<?php
namespace lib\activity;
class register_beans extends activity
{
    public static function join($row, $parameter='', $call_back='' )
    {
        $parameter['user_id'] = static::$userModel->iid;
        $parameter['event'] = 'regiser';
        return parent::join($row, $parameter, ['class' => '\lib\activity\register_beans', 'method'=>'join_call_back']);
    }

    public static function join_call_back($row, $parameter)
    {
        \lib\nodes\UserMessage::sendBeans($parameter['user_id'], $parameter['event'], $row['rewardNumber']);
    }

    public static function refurbish($a_id=1)
    {
        parent::refurbish($a_id);
    }
}
