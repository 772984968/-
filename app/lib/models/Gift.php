<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_gift".
 *
 * @property integer $iid
 * @property string $name
 * @property string $diamond
 */
class Gift extends BaseModel
{
    const LIST_CACHE_NAME = 'gift_list_chache_list';
    const NUMBER_NAME = 'iid';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['diamond'], 'number'],
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
            'name' => 'Name',
            'diamond' => 'Diamond',
        ];
    }

    //取列表数据并缓存
    public static function getCacheList($fields = '*', $order = 'DESC')
    {
        $cache = Yii::$app->getCache();
        $data = $cache->get(self::LIST_CACHE_NAME);
        if( !$data ) {
            $data = self::find()
                ->select($fields)
                ->orderBy(static::NUMBER_NAME.' ASC')
                ->asArray()
                ->all();
            $cache->set(static::LIST_CACHE_NAME, $data);
        }
        return $data;
    }
}
