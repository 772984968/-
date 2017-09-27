<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "{{%admin_dolog}}".
 *
 * @property string $id
 * @property string $ip
 * @property integer $time
 * @property integer $uid
 * @property string $username
 * @property string $action
 * @property string $title
 * @property string $doing
 */
class AdminDolog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_dolog}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'uid'], 'integer'],
            [['uid'], 'required'],
            [['ip'], 'string', 'max' => 20],
            [['username', 'action'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 80],
            [['doing'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', '操作ip'),
            'time' => Yii::t('app', '操作时间'),
            'uid' => Yii::t('app', '管理员id'),
            'username' => Yii::t('app', '操作用户用户名'),
            'action' => Yii::t('app', '操作动作'),
            'title' => Yii::t('app', '名称'),
            'doing' => Yii::t('app', '具体操作描述'),
        ];
    }
}
