<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_user_pay_log".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property string $member
 * @property string $create_time
 */
class UserPayLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_user_pay_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'member'], 'required'],
            [['user_id'], 'integer'],
            [['member'], 'number'],
            [['create_time'], 'safe'],
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
            'member' => 'Member',
            'create_time' => 'Create Time',
        ];
    }
}
