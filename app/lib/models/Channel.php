<?php

namespace lib\models;

use Yii;
use lib\traits\operateDbTrait;
/**
 * This is the model class for table "at_channel".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property string $name
 * @property integer $type
 * @property string $cid
 * @property integer $ctime
 * @property string $pushUrl
 * @property string $httpPullUrl
 * @property string $hlsPullUrl
 * @property string $rtmpPullUrl
 * @property integer $status
 */
class Channel extends \yii\db\ActiveRecord
{
    use operateDbTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_channel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'status', 'look_number', 'roomid'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['cid'], 'string', 'max' => 32],
            ['ctime', 'safe'],
            [['pushUrl', 'httpPullUrl', 'hlsPullUrl', 'rtmpPullUrl', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'user_id' => 'User ID',
            'name' => 'Name',
            'type' => 'Type',
            'cid' => 'Cid',
            'ctime' => 'Ctime',
            'pushUrl' => 'Push Url',
            'httpPullUrl' => 'Http Pull Url',
            'hlsPullUrl' => 'Hls Pull Url',
            'rtmpPullUrl' => 'Rtmp Pull Url',
            'status' => 'Status',
        ];
    }

    public function getUserinfo()
    {
        return $this->hasOne(User::className(), ['iid'=>'user_id'])->select('iid,nickname,head,vip_type,fans_number');
    }
}
