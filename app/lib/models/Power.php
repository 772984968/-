<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "{{%power}}".
 *
 * @property string $id
 * @property integer $pid
 * @property string $name
 * @property string $url
 * @property integer $is_show
 * @property string $uptime
 * @property integer $order
 * @property string $icon
 * @property integer $state
 * @property integer $isdefault
 */
class Power extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%power}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'is_show', 'uptime', 'order', 'state', 'isdefault'], 'integer'],
            [['name'], 'string', 'max' => 15],
            [['url'], 'string', 'max' => 45],
            [['icon'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pid' => Yii::t('app', '父级'),
            'name' => Yii::t('app', '权限描述'),
            'url' => Yii::t('app', '权限资源'),
            'is_show' => Yii::t('app', '菜单状态.0非菜单.1菜单'),
            'uptime' => Yii::t('app', '修改时间'),
            'order' => Yii::t('app', '菜单排序'),
            'icon' => Yii::t('app', '菜单图标'),
            'state' => Yii::t('app', '状态,1可用，0为不可用'),
            'isdefault' => Yii::t('app', '是否默认菜单  0否  1是'),
        ];
    }
}
