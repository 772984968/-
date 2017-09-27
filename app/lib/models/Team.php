<?php

namespace lib\models;
use lib\traits\operateDbTrait;
use Yii;

/**
 * This is the model class for table "at_team".
 *
 * @property integer $iid
 * @property string $name
 * @property integer $user_id
 * @property integer $member_number
 * @property integer $wy_tid
 * @property string $intro
 * @property string $create_time
 */
class Team extends \yii\db\ActiveRecord
{
    use operateDbTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'member_number', 'wy_tid'], 'integer'],
            [['create_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['intro','icon'], 'string', 'max' => 100],
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
            'user_id' => 'User ID',
            'member_number' => 'Member Number',
            'wy_tid' => 'Wy Tid',
            'intro' => 'Intro',
            'create_time' => 'Create Time',
        ];
    }
}
