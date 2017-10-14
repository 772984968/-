<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_member".
 *
 * @property integer $iid
 * @property string $name
 * @property integer $withdrew_ratio
 * @property integer $friend_number
 * @property integer $flock_number
 * @property integer $flock_peopel_number
 * @property string $operates
 * @property integer $is_default
 * @property integer $price
 */
class Member extends BaseModel
{
    const LIST_CACHE_NAME = 'member_list';
    const NUMBER_NAME = 'friend_number';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'friend_number', 'flock_number', 'flock_peopel_number', 'is_default'], 'integer'],
            [['price', 'invite_price'],'number'],
            [['operates'], 'string'],
            [['name','price'], 'required'],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => Yii::t('common','iid'),
            'name' => Yii::t('common','name'),
            'friend_number' => Yii::t('common','friend_number'),
            'flock_number' => Yii::t('common','flock_number'),
            'flock_peopel_number' => Yii::t('common','flock_peopel_number'),
            'operates' => Yii::t('common','operates'),
            'is_default' => Yii::t('common','is_default'),
            'price' => Yii::t('common','price'),
        ];
    }

    //取默认级别
    public static function getDefaultMember()
    {
        return self::findOne(['is_default'=>1])->toArray();
    }

    //取列表数据并缓存
    public static function getCacheList($fields = '*', $order = 'DESC')
    {
        $cache = Yii::$app->getCache();
        $data = $cache->get(self::LIST_CACHE_NAME);
 
        if( !$data ) {
            $data = self::find()
                ->select($fields)
                ->asArray()
                ->all();
            foreach($data as $key => $row) {
                $data[$key]['powers'] = AppPower::idToPowers($row['operates']);
            }
            $cache->set(static::LIST_CACHE_NAME, $data);
        }
        return $data;
    }
    
    
}
