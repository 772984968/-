<?php

namespace lib\models;

use Yii;
use lib\traits\operateDbTrait;
/**
 * This is the model class for table "at_user_notice".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property string $type
 * @property string $content
 * @property string $create_time
 */
class UserNotice extends \yii\db\ActiveRecord
{
    use operateDbTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_user_notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id', 'required'],
            ['user_id', 'integer'],
            [['create_time'], 'safe'],
            [['type'], 'string', 'max' => 10],
            [['content'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'type' => 'Type',
            'content' => 'Content',
            'create_time' => 'Create Time',
        ];
    }
}
