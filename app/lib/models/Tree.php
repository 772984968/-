<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "tree".
 *
 * @property integer $iid
 * @property string $name
 * @property integer $pid
 */
class Tree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'pid' => 'Pid',
        ];
    }
}
