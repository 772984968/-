<?php

namespace lib\models;

use Yii;


/**
 * This is the model class for table "at_activity_reward".
 *
 * @property integer $iid
 * @property string $name
 * @property string $event
 * @property string $parameter
 * @property string $rewardType
 * @property string $rewardNumber
 * @property string $s_dt
 * @property string $e_dt
 * @property integer $vip
 * @property integer $number_of_times
 * @property string $ refresh_time
 */
class ActivityReward extends \yii\db\ActiveRecord
{
    public static $userModel;

    const USER_ACTIVITY_REWARD_STATUS = 'user_activity_reward_status';
    const USER_ACTIVITY_REGISTER_RANK='user_activity_register_rank';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_activity_reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rewardType'], 'string'],
            [['rewardNumber'], 'number'],
            [['s_dt', 'e_dt', 'refresh_time'], 'safe'],
            [['vip', 'number_of_times'], 'integer'],
            [['name'], 'string', 'max' => 15],
            [['event'], 'string', 'max' => 20],
            [['parameter'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'name' => 'Name',
            'event' => 'Event',
            'parameter' => 'Parameter',
            'rewardType' => 'Reward Type',
            'rewardNumber' => 'Reward Number',
            's_dt' => 'S Dt',
            'e_dt' => 'E Dt',
            'vip' => 'Vip',
            'number_of_times' => 'Number Of Times',
            'refresh_time' => 'Refresh Time',
        ];
    }

    //获取奖励
    public static function get($event, $parameter='')
    {
        $activitys = static::getRows($event); //取直活动
        foreach ($activitys as $row) {
            $class_name = "lib\\activity\\".$row['name'];
            if(method_exists($class_name, 'join')) {
                $class_name::$userModel = static::$userModel;
                $class_name::join($row, $parameter);
            }
        }

    }
    //取活动的所有行
    public static function getRows($name)
    {
        $data = static::find()
            ->where(['event'=>$name])
            ->orderBy('iid ASC')
            ->asArray()
            ->all();
        return $data;
    }

}
