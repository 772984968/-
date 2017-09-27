<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "kk_app_ads".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $image
 * @property string $url
 * @property integer $addtime
 */
class AppAds extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_ads}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'addtime'], 'required'],
            [['type', 'addtime'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['image', 'url'], 'string', 'max' => 200]
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
            'image' => 'Image',
            'url' => 'Url',
            'addtime' => 'Addtime',
        ];
    }
}
