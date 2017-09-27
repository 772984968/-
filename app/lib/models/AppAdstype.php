<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "kk_app_adstype".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property integer $addtime
 */
class AppAdstype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_adstype}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'addtime'], 'integer'],
            [['addtime'], 'required'],
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
            'type' => 'Type',
            'name' => 'Name',
            'addtime' => 'Addtime',
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
}
