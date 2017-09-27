<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_user_withdraw_deposit".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property string $ali_account
 * @property string $ali_name
 * @property string $number
 * @property integer $status
 * @property string $pay_sn
 * @property string $create_time
 */
class UserWithdrawDeposit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_user_withdraw_deposit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['number'], 'number'],
            [['create_time'], 'safe'],
            [['ali_account'], 'string', 'max' => 50],
            [['ali_name'], 'string', 'max' => 10],
            [['pay_sn'], 'string', 'max' => 30],
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
            'ali_account' => 'Ali Account',
            'ali_name' => 'Ali Name',
            'number' => 'Number',
            'status' => 'Status',
            'pay_sn' => 'Pay Sn',
            'create_time' => 'Create Time',
        ];
    }
}
