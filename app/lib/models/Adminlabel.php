<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "hlzx_adminlabel".
 *
 * @property string $name
 */
class Adminlabel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%label}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30],
            //[['update_time', 'create_time'], 'safe'],
            [['image','textarea','texts','update_time','create_time','radio1','select1','name2'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '标签名称',
        ];
    }
}
