<?php

namespace lib\models;

use Yii;

/**
 * 分组表
 * This is the model class for table "at_buddy_group".
 * @property integer $iid
 * @property integer $user_id
 * @property string $name
 * @property integer $list_order
 */
class BuddyGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_buddy_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'list_order','system_group_id', 'is_system'], 'integer'],
            [['name'], 'string', 'max' => 20],
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
            'name' => '名称',
            'list_order' => 'List Order',
        ];
    }


    public function move($top)
    {
        $list = static::find()
            ->select('iid,name')
            ->where(['user_id'=>$this->user_id])
            ->orderBy('list_order ASC,iid ASC')
            ->all();

        $minListOrder = 0;  //当前的序号

        if($top == 0) {
            $this->list_order= $minListOrder;
            $this->save();
            $minListOrder++;
        }
        foreach($list as $row) {
            if($row['iid'] == $this->iid) {
                continue;
            }
            $row->list_order = $minListOrder;
            $minListOrder++;
            $row->save();
            if($row['iid'] == $top) {
                $this->list_order=$minListOrder;
                $this->save();
                $minListOrder++;
            }
        }
        return true;

    }

    //取系统分组名称
    public function getSysgroupname(){
        return $this->hasOne(SystemBuddyGroup::className(), ['iid'=>'system_group_id']);
    }

    public static function has($userId, $name)
    {
        return static::findOne(['user_id'=>$userId, 'name'=>$name]);
    }
    
    public static function getList($userId)
    {
        $sysGroup = SystemBuddyGroup::getCacheList();

        $data = static::find()
                ->with(['sysgroupname'])
                ->select('iid,name,system_group_id')
                ->where(['user_id'=>$userId])
                ->orderBy('list_order ASC,iid ASC')
                ->asArray()
                ->all();

        $newdata = [];
        foreach($sysGroup as $row) {
            $newdata[$row['iid']] = ['iid'=>$row['iid'], 'name'=>$row['name'], 'system_group_id'=>$row['iid'],'buddy'=>[]];
        }

        if($data)
        {
            foreach($sysGroup as $row) {
                $newdata[$row['iid']] = ['iid'=>$row['iid'], 'name'=>$row['name'], 'system_group_id'=>$row['iid'],'buddy'=>[]];
            }

            foreach($data as $key => $row)
            {
                if($row['sysgroupname']) {
                    $row['name'] = $row['sysgroupname']['name'];
                }
                unset($row['sysgroupname']);
                unset($row['system_group_id']);
                $row['buddy'] = [];
                $newdata[$row['iid']] = $row;
            }
        }

        return $newdata;
        
    }

    public static function getNoBuddyList($userId){
        $sysGroup = SystemBuddyGroup::getCacheList();
        $newdata = [];
        $data = static::find()
            ->with(['sysgroupname'])
            ->select('iid,name,system_group_id')
            ->where(['user_id'=>$userId])
            ->orderBy('list_order ASC,iid ASC')
            ->asArray()
            ->all();

        foreach($sysGroup as $row) {
            $newdata[] = ['iid'=>$row['iid'], 'name'=>$row['name'], 'system_group_id'=>$row['iid']];
        }

        if($data)
        {
            foreach($data as $key => $row)
            {
                if($row['sysgroupname']) {
                    $row['name'] = $row['sysgroupname']['name'];
                }
                unset($row['sysgroupname']);
                $newdata[] = $row;
            }
        }
        return $newdata;
    }

    //移动分组好友到默认分组
    public static function moveBuddyToDefaultGroup($userId, $source)
    {
        $default_group_id = SystemBuddyGroup::getDefaultGroupIid();
        $sql = "UPDATE at_buddy SET group_id=$default_group_id where user_id=$userId AND group_id=$source";
        Yii::$app->getDb()->createCommand($sql)->execute();
        return true;
    }

    //移动好友到别的分组
    public static function moveBuddyToOtherGroup($userId, $buddy_id, $group_id) {
        $buddyModel = Buddy::findOne(['user_id'=>$userId, 'buddy_id'=>$buddy_id]);
        if(!$buddyModel) {
            return false;
        }

        $buddyGroupModel = static::findOne(['user_id'=>$userId, 'iid'=> $group_id]);
        if(!$buddyGroupModel) {
            return false;
        }

        $buddyModel->group_id = $group_id;
        return $buddyModel->save();
    }

    public static function getDefaultGroup($userId)
    {
        return static::findOne(['user_id'=>$userId, 'is_system'=>1]);
    }
}
