<?php

namespace lib\models;

use Yii;

/**
 * 好友表
 * This is the model class for table "at_buddy".
 * @property integer $iid
 * @property integer $user_id
 * @property integer $group_id
 * @property integer $buddy_id
 */
class Buddy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_buddy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id', 'buddy_id'], 'integer'],
            ['remark', 'string', 'max' => 15],
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
            'group_id' => 'Group ID',
            'buddy_id' => 'Buddy ID',
        ];
    }
}
