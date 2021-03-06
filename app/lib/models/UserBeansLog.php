<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_user_beans_log".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property integer $type
 * @property string $number
 * @property integer $source_user_id
 * @property string $note
 * @property string $create_time
 */
class UserBeansLog extends UserDiamondLog
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_user_beans_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'source_user_id'], 'integer'],
            [['number'], 'number'],
            [['create_time'], 'safe'],
            [['note'], 'string', 'max' => 255],
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
            'type' => 'Type',
            'number' => 'Number',
            'source_user_id' => 'Source User ID',
            'note' => 'Note',
            'create_time' => 'Create Time',
        ];
    }
}
