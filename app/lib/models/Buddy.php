<?php

namespace lib\models;

use Yii;

/**
 * 好友表
 * This is the model class for table "at_buddy".
 * @property integer $iid
 * @property integer $user_id
 * @property integer $group_id
 * @property integer $buddy_id
 */
class Buddy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_buddy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id', 'buddy_id'], 'integer'],
            ['remark', 'string', 'max' => 15],
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
            'group_id' => 'Group ID',
            'buddy_id' => 'Buddy ID',
        ];
    }

    public function getUserinfo(){
        return $this->hasOne(User::className(), ['iid'=>'buddy_id'])->select('iid,nickname,head,wy_accid');
    }

    public static function getList($user_id) {
        return static::find()->select('group_id,buddy_id')->with('userinfo')->where(['user_id'=>$user_id])->asArray()->all();
    }

    public static function bIsaBuddy($a, $b) {
        return static::findOne(['user_id'=>$a, 'buddy_id'=>$b]);
    }

    public static function deleteBuddy($user_id, $buddy_id) {

        $result1 = static::bIsaBuddy($user_id, $buddy_id);
     
        if($result1) {
            $result1->delete();
        }

        $result2 = static::bIsaBuddy($buddy_id, $user_id);
        if($result2) {
            $result2->delete();
        }
    }

    
}
