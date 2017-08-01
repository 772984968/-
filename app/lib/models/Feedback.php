<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "er_feedback".
 *
 * @property integer $feedback_id
 * @property integer $user_id
 * @property string $ content
 * @property integer $create_time
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%feedback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'content'], 'required'],
            [['user_id', 'create_time'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'feedback_id' => 'Feedback ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'create_time' => 'Create Time',
        ];
    }
}
