<?php
namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_activity_detailed".
 *活动中心
 * @property integer $iid
 * @property integer $title
 * @property string $s_dt
 * @property string $e_dt
 * @property integer $url
 */
class ActivityCenter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_activity_center';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['iid','integer'],
            [['s_dt', 'e_dt'], 'safe'],
            [['title'], 'string', 'max' => 30],
            [['url','image'], 'string', 'max' =>255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'title' => 'Title',
            'url' => 'Url',
            's_dt' => 'S Dt',
            'e_dt' => 'E Dt',
        ];
    }

}
