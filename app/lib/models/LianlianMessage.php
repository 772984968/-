<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "er_lianlian_message".
 *
 * @property integer $lianlian_message_id
 * @property integer $user_id
 * @property string $ content
 * @property integer $create_time
 */
class LianlianMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lianlian_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'create_time' => 'Create Time',
        ];
    }
}
