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
            [['s_dt', 'e_dt', 'refresh_time'], 'safe'],
            [['name'], 'string', 'max' => 15],
            [['event','discription'], 'string', 'max' => 20],
            [['image','url'], 'string', 'max' => 15],
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
            's_dt' => 'S Dt',
            'e_dt' => 'E Dt',
            'refresh_time' => 'Refresh Time',
        ];
    }

    //触发事件
    public static function get($event, $parameter='')
    {

        $data = static::getRows($event); //取直活动
        var_dump($data);die;
        if(!$data) {
            return false;
        }

        $rst = [];
        foreach($data as $row)
        {
            if(!static::check($row)) {
                continue;
            }
            $class_name = '\lib\activity\\'.$row['name'];
            if(method_exists($class_name, 'join')) {
                $class_name::$userModel = static::$userModel;
                $rst[] = $class_name::join($row, $parameter);
            }
        }
        
        return $rst;

    }


    //检查活动是否开始了
    public static function check($row)
    {
        if(strtotime($row['s_dt'])>time()) {
            return false;
        }

        if( $row['e_dt']<date('Y-m-d H:i:s', time()) ) {
            return false;
        }

        return true;
    }


    //取活动的所有行
    public static function getRows($event)
    {
        $time = time();
        $data = static::find()
            ->where(['event'=>$event])
            ->andWhere("UNIX_TIMESTAMP(s_dt)<=$time AND UNIX_TIMESTAMP(e_dt)>=$time")
            ->orderBy('iid ASC')
            ->asArray()
            ->all();
        return $data;
    }

    //重置领取记录
    public static function refurbish()
    {
        $data = static::find()->asArray()->all();
        foreach ($data as $row)
        {
            $class_name = '\lib\activity\\'.$row['name'];

            if(method_exists($class_name, 'refurbish')) {
                $class_name::refurbish();
            }
        }
    }

}

