<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_system_buddy_group".
 *
 * @property integer $iid
 * @property string $name
 * @property boolean $cannot_delete
 * @property boolean $is_default
 */
class SystemBuddyGroup extends BaseModel
{
    const LIST_CACHE_NAME = 'System_Buddy_Group_list';
    const NUMBER_NAME = 'iid';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_system_buddy_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cannot_delete', 'is_default'], 'boolean'],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'name' => 'Name',
            'cannot_delete' => 'Cannot Delete',
            'is_default' => 'Is Default',
        ];
    }

    public static function getDefaultGroupIid()
    {
        $list = static::getCacheList();
        foreach($list as $row) {
            if($row['is_default']) {
                return $row['iid'];
            }
        }
    }

    /*public function init()
    {
        $this->on(self::EVENT_AFTER_INSERT,[$this, 'after_install']);
    }

    public function after_install()
    {
        $maxid = 0;
        $limit = 300;
        while(1){
            $users = User::find()
                    ->where("iid>$maxid")
                    ->orderBy('iid ASC')
                    ->limit($limit)
                    ->asArray()
                    ->all();
            if($users)
            {
                $values = '';
                foreach ($users as $user)
                {
                    $values .= "({$user['iid']},{$this->iid}),";
                    $maxid = $user['iid'];
                }
                $values = trim($values,',');
                $sql = "INSERT INTO at_buddy_group(user_id,system_group_id) VALUES$values";
                Yii::$app->getDb()->createCommand($sql)->execute();
            }
            else
            {
                break;
            }
        }
    }*/
}
