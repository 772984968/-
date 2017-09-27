<?php

namespace lib\models;
use lib\traits\operateDbTrait;
use Yii;

/**
 * This is the model class for table "at_user_verify_info".
 *
 * @property integer $iid
 * @property integer $receive_user_id
 * @property integer $request_user_id
 * @property integer $type
 * @property integer $status
 * @property string $create_time
 */
class UserVerifyInfo extends \yii\db\ActiveRecord
{
    use operateDbTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_user_verify_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','target_id'], 'required'],
            [['user_id', 'target_id', 'type', 'status', 'link_id', 'is_ratify', 'relevance_id'], 'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'receive_user_id' => 'Receive User ID',
            'request_user_id' => 'Request User ID',
            'type' => 'Type',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'receive_delete' => 'Receive Delete',
            'request_delete' => 'Request Delete',
        ];
    }


    public function getUserinfo(){
        return $this->hasOne(User::className(),['iid'=>'target_id'])->select('iid,nickname,head');
    }


    public function getTeaminfo() {
        return $this->hasOne(Team::className(),['iid'=>'relevance_id'])->select('iid,icon,name');
    }

}
