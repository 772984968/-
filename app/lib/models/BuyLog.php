<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_buy_log".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property integer $order_id
 * @property integer $member_id
 * @property string $start_date
 * @property string $end_date
 * @property string $create_time
 */
class BuyLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_buy_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'order_id', 'member_id'], 'integer'],
            [['start_date', 'end_date', 'create_time'], 'safe'],
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
            'order_id' => 'Order ID',
            'member_id' => 'Member ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'create_time' => 'Create Time',
        ];
    }
}
