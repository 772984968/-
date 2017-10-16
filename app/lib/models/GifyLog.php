<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_gify_log".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property integer $receiver_id
 * @property string $gify_name
 * @property string $gify_number
 * @property integer $gify_price
 * @property integer $scale
 * @property string $price
 * @property string $create_time
 */
class GifyLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_gify_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'receiver_id', 'gify_number', 'scale'], 'integer'],
            [['price', 'gify_price'], 'number'],
            [['create_time'], 'safe'],
            [['gify_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'user_id' => 'User ID',
            'receiver_id' => 'Receiver ID',
            'gify_name' => 'Gify Name',
            'gify_number' => 'Gify Number',
            'gify_price' => 'Gify Price',
            'scale' => 'Scale',
            'price' => 'Price',
            'create_time' => 'Create Time',
        ];
    }
}
