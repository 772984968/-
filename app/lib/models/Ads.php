<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "{{%ads}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $image
 * @property string $url
 * @property integer $addtime
 */
class Ads extends BaseModel
{
    const LIST_CACHE_NAME = 'system_ads_list_';
    const NUMBER_NAME = 'listorder';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ads}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['addtime'], 'required'],
            [['addtime', 'listorder', 'internal_jump'], 'integer'],
            [['type'], 'string', 'max' => 10],
            [['name','parameter'], 'string', 'max' => 100],
            [['image', 'url'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', '广告类型'),
            'name' => Yii::t('app', '名称'),
            'image' => Yii::t('app', '图片'),
            'url' => Yii::t('app', '链接地址'),
            'addtime' => Yii::t('app', '添加时间'),
        ];
    }

    /**
     * [getGood innerjoin db_order_good]
     * @return [type] [description]
     */
    public function getAdstype()
    {
        return $this->hasOne(Adstype::className(), ['type' => 'type']);
    }

}
