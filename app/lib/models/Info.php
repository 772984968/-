<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "info".
 *
 * @property string $id
 * @property integer $uid
 * @property string $username
 * @property string $phone
 * @property string $llid
 * @property string $university
 * @property string $email
 * @property string $slogan
 * @property string $head
 * @property integer $date
 */
class Info extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'date'], 'integer'],
            [['username', 'llid', 'university', 'email', 'slogan', 'head'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
            [['uid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'username' => 'Username',
            'phone' => 'Phone',
            'llid' => 'Llid',
            'university' => 'University',
            'email' => 'Email',
            'slogan' => 'Slogan',
            'head' => 'Head',
            'date' => 'Date',
        ];
    }

    //取地址为Area的，报名用户ID
    public static function getAreaUserId($area)
    {
        $rst = static::find()
            ->select('user_id')
            ->where(['division'=>$area])
            ->asArray()
            ->all();
        $ids = [];
        foreach ($rst  as $row) {
            $ids[] = $row['user_id'];
        }
        return $ids;
    }
}
