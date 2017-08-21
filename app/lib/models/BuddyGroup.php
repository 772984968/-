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
            [['user_id', 'list_order','system_group_id'], 'integer'],
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
        $data = static::find()
                ->with(['sysgroupname'])
                ->select('iid,name,system_group_id')
                ->where(['user_id'=>$userId])
                ->orderBy('list_order ASC,iid ASC')
                ->asArray()
                ->all();

        if($data)
        {
            foreach($data as $key => $row)
            {
                if($row['sysgroupname']) {
                    $data[$key]['name'] = $row['sysgroupname']['name'];
                }
                unset($data[$key]['sysgroupname']);
            }
        }
        return $data;
    }
}
