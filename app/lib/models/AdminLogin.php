<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "{{%admin_login}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $account
 * @property string $nickname
 * @property string $login_ip
 * @property integer $login_time
 */
class AdminLogin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_login}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'login_time'], 'integer'],
            [['account', 'nickname'], 'string', 'max' => 30],
            [['login_ip'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', '管理员id'),
            'account' => Yii::t('app', '登录账号'),
            'nickname' => Yii::t('app', '昵称'),
            'login_ip' => Yii::t('app', '登陆ip'),
            'login_time' => Yii::t('app', '登陆时间'),
        ];
    }
}
