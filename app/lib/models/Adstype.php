<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "db_adstype".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property integer $addtime
 */
class Adstype extends BaseModel
{
    const LIST_CACHE_NAME = 'ads_type_list_';
    const NUMBER_NAME = 'id';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%adstype}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['addtime'], 'required'],
            [['addtime'], 'integer'],
            [['type'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '广告类型',
            'name' => '名称',
            'addtime' => '添加时间',
        ];
    }

    public function adstypelist(){
    	$adstpe = $this->find()->orderBy('id ASC')->all();
    	if (!empty($adstpe)){
    		foreach ($adstpe as $key=>$val){
    			$redata[$val['type']] = $val['name'];
    		}
    		return $redata;
    	}
    }

    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['type' => 'type'])->orderBy('listorder DESC');
    }

    //取缓存中 id 序号行
    public static function getCacheRow( $id ) {

        $data = static::getCacheList();
        foreach($data as $row) {
            if($row['type'] == $id) {
                return $row;
            }
        }
        return false;
    }

    

}
