<?php

namespace lib\models;

use Yii;
use yii\rhy\Config;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $key
 * @property string $value
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['value','html','option'], 'string'],
            [['type','dt'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['key'], 'string', 'max' => 50],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'key' => '变量',
            'value' => '值',
            'html' => 'html表单类型',
            'option' => 'html表单参数',
            'type' => '1系统设置2支付设置3其他',
        ];
    }

    /**
     * @desc    查询所有系统参数
     * @access  public
     * @param   void
     * @return  array
     */
    public static function getSetting()
    {
        $settingArray = array();
        $setting      = self::find()->all();
        if (empty($setting))
        {
            return $settingArray;
        }

        foreach ($setting as $set)
        {
            $settingArray[$set['key']] = $set['value'];
        }

        return $settingArray;
    }

    /**
     * @desc    查询指定类型的设置
     * @access  public
     * @param   void
     * @return  array
     */
    public static function getSettingtype($type=0)
    {
        $settingArray = array();
        $setting      = self::find()->where(['type'=>$type])->all();
        if (empty($setting))
        {
            return $settingArray;
        }

        foreach ($setting as $set)
        {
            $settingArray[$set['key']] = $set['value'];
        }

        return $settingArray;
    }

    /**
     * @desc    查询所有系统参数
     * @access  public
     * @param   $type = 0是所有的数据
     * @return  array
     */
    public static function getAll($type = 0)
    {
        if($type != 0)
        {
            $setting      = self::find()->where(['type'=>$type])->asArray()->all();
        }
        else
        {
            $setting      = self::find()->asArray()->all();
        }

        return Config::toHtml($setting);
    }

}
