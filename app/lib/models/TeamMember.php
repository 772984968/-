<?php

namespace lib\models;

use Yii;
use lib\traits\operateDbTrait;
/**
 * This is the model class for table "at_team_member".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property integer $team_id
 */
class TeamMember extends \yii\db\ActiveRecord
{
    use operateDbTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_team_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'team_id'], 'integer'],
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
            'team_id' => 'Team ID',
        ];
    }

    public function getTeaminfo() {
        return $this->hasOne(Team::className(), ['iid'=>'team_id']);
    }


    public static function formartListData($data) {
        $newdata = [];
        foreach($data as $row) {
            if(!empty($row['teaminfo'])) {
                $newdata[] = $row['teaminfo'];
            }
        }
        return $newdata;
    }

    public static function getMembers($tid) {
        return User::find()
            ->select('at_user.iid,nickname,head,wy_accid')
            ->innerJoin('at_team_member as tm','at_user.iid=tm.user_id')
            ->where(['team_id'=>$tid])
            ->asArray()
            ->all();
    }

    
    public static function inTeam($uid, $tid) {
        return static::findOne(['user_id'=>$uid, 'team_id'=>$tid]);
    }
}
