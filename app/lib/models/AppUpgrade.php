<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_app_upgrade".
 *
 * @property integer $iid
 * @property string $title
 * @property integer $client
 * @property integer $status
 * @property integer $version_code
 * @property string $apk_url
 * @property string $upgrade_point
 * @property string $create_time
 * @property string $describe
 */
class AppUpgrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_app_upgrade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apk_url', 'title'], 'required'],
            [['client', 'status', 'version_code'], 'integer'],
            [['create_time'], 'safe'],
            [['title'], 'string', 'max' => 20],
            [['apk_url', 'describe'], 'string', 'max' => 100],
            [['upgrade_point'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'title' => 'Title',
            'client' => 'Client',
            'status' => 'Status',
            'version_code' => 'Version Code',
            'apk_url' => 'Apk Url',
            'upgrade_point' => 'Upgrade Point',
            'create_time' => 'Create Time',
            'describe' => 'Describe',
        ];
    }

    public static function getNewVersion($client=0) {
        return static::find()
            ->where(['client'=>$client, 'status'=>1])
            ->orderBy('iid DESC')
            ->limit(1)
            ->asArray()
            ->one();
    }
}
