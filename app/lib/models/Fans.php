<?php

namespace lib\models;

use Yii;
use lib\traits\operateDbTrait;
/**
 * This is the model class for table "at_fans".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property integer $fans_id
 * @property string $create_time
 */
class Fans extends \yii\db\ActiveRecord
{
    use operateDbTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_fans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fans_id'], 'integer'],
            [['create_time'], 'safe'],
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
            'fans_id' => 'Fans ID',
            'create_time' => 'Create Time',
        ];
    }

    //添加粉丝
    public static function addFollow($user_id, $follow_user_id)
    {
        //已添加，直接返回
        if(static::findOne(['user_id'=>$follow_user_id, 'fans_id'=>$user_id])) {
            return true;
        }
        $t = Yii::$app->getDb()->beginTransaction();

        $model = new static();
        $model->user_id = $follow_user_id;
        $model->fans_id = $user_id;
        if(!$model->save()) {
            $t->rollBack();
            return false;
        }

        $userModel = User::findOne($follow_user_id);
        $userModel->fans_number++;
        if(!$userModel->save()) {
            $t->rollBack();
            return false;
        }

        $fansModel = User::findOne($user_id);
        $fansModel->follow_number++;
        if(!$fansModel->save()) {
            $t->rollBack();
            return false;
        }

        $t->commit();
        return true;
    }

    //取消关注
    public static function cencelFollow($user_id, $follow_user_id)
    {
        //没添加，直接返回
        $result = static::findOne(['user_id'=>$follow_user_id, 'fans_id'=>$user_id]);
        if(!$result) {
            return true;
        }
        $t = Yii::$app->getDb()->beginTransaction();

        $result->delete();

        $userModel = User::findOne($follow_user_id);
        $userModel->fans_number--;
        if(!$userModel->save()) {
            $t->rollBack();
            return false;
        }

        $fansModel = User::findOne($user_id);
        $fansModel->follow_number--;
        if(!$fansModel->save()) {
            $t->rollBack();
            return false;
        }

        $t->commit();
        return true;
    }

    public function getFansinfo()
    {
        return $this->hasOne(User::className(), ['iid'=>'fans_id'])->select('iid,nickname,head,fans_number,vip_type');
    }

    public function getFollowinfo()
    {
        return $this->hasOne(User::className(), ['iid'=>'user_id'])->select('iid,nickname,head,fans_number,vip_type');
    }


    //我的粉丝列表
    public static function getMyFansList($user_id, $isNext)
    {
        $join = [
            'type' => 'left',
            'table'=>"at_fans AS fs",
            'on' => "fs.user_id=at_fans.fans_id AND fs.fans_id=at_fans.user_id"
        ];
        $select = "at_fans.fans_id,at_fans.iid,fs.iid as mutual";
        static::$key_name = 'at_fans.iid';
        $result = self::list(['at_fans.user_id'=>$user_id], $isNext, 'fansinfo', 20, $join, $select);
        return self::format($result, 'fansinfo');
    }

    //其他人的粉丝列表
    public static function getOtherFansList($other_user_id, $user_id, $isNext)
    {
        $join = [
            'type' => 'left',
            'table'=>"at_fans AS fs",
            'on' => "fs.user_id=at_fans.fans_id AND fs.fans_id=$user_id"
        ];
        $select = "at_fans.fans_id,at_fans.iid,fs.iid as mutual";
        static::$key_name = 'at_fans.iid';
        $result = self::list(['at_fans.user_id'=>$other_user_id], $isNext, 'fansinfo', 20, $join, $select);
        return self::format($result, 'fansinfo');
    }

    //我的关注列表
    public static function getMyFollowList($user_id, $isNext)
    {
        $result = self::list(['fans_id'=>$user_id], $isNext, 'followinfo');
        $data = [];
        foreach($result as $row) {
            $row['followinfo']['mutual'] = '1';
            $data[] = $row['followinfo'];
        }
        return $data;
    }

    //他人关注列表
    public static function getOtherFollowList($other_user_id, $user_id, $isNext)
    {
        $join = [
            'type' => 'left',
            'table'=>"at_fans AS fs",
            'on' => "fs.user_id=at_fans.user_id AND fs.fans_id=$user_id"
        ];
        $select = "at_fans.user_id,at_fans.iid,fs.iid as mutual";
        static::$key_name = 'at_fans.iid';
        $result = self::list(['at_fans.fans_id'=>$other_user_id], $isNext, 'followinfo', 20, $join, $select);
        return self::format($result, 'followinfo');
    }


    //调整数据格式
    private static function format(&$result, $infoField)
    {
        $data = [];
        foreach($result as $row) {
            $row[$infoField]['mutual'] = !empty($row['mutual']) ? '1' : '0';
        
            $row[$infoField]['head'] = \lib\nodes\UserNode::get_head_url($row[$infoField]['head']);
            $data[] = $row[$infoField];
        }
        return $data;
    }

}
