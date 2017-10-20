<?php
namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_activity_detailed".
 *
 * @property integer $iid
 * @property integer $a_id
 * @property string $parameter
 * @property string $rewardType
 * @property integer $rewardNumber
 * @property integer $number_of_times
 * @property integer $vip
 */
class ActivityDetailed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_activity_detailed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['a_id', 'rewardNumber', 'number_of_times', 'vip'], 'integer'],
            [['rewardType'], 'string'],
            [['parameter'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'a_id' => 'A ID',
            'parameter' => 'Parameter',
            'rewardType' => 'Reward Type',
            'rewardNumber' => 'Reward Number',
            'number_of_times' => 'Number Of Times',
            'vip' => 'Vip',
        ];
    }

    //取具体活动的详情
    public static function getTypeRows($a_id)
    {
        $data =  static::find()->where(['a_id'=>$a_id])->orderBy('iid ASC')->asArray()->all();
        foreach($data as $key => $val)
        {
            $data[$key]['parameter'] = json_decode($val['parameter']);
        }
        return $data;
    }
}
