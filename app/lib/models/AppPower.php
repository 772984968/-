<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_app_power".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $name
 * @property string $url
 * @property integer $order
 * @property integer $state
 */
class AppPower extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_app_power';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'name', 'url'], 'required'],
            [['pid', 'order', 'state','all_use'], 'integer'],
            [['name'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'name' => 'Name',
            'url' => 'Url',
            'order' => 'Order',
            'state' => 'State',
            'all_use' => 'all_use',
        ];
    }

    //通过操作ID取对应的,操作
    public static function idToPowers($ids)
    {
        if(!$ids || $ids == ',') {
            return [];
        }

        $ids = explode(',', $ids);

        $result = static::find()
                    ->select('url')
                    ->where(['in','id',$ids])
                    ->asArray()
                    ->all();
        if(!$result) {
            return [];
        }

        $powers = [];
        foreach( $result as $row ) {
            if($row['url'] && $row['url'] != 'null') {
                $powers[] = $row['url'];
            }
        }

        return $powers;

    }
}
