<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "er_recommend".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $image
 * @property string $url
 * @property integer $create_time
 * @property integer $listorder
 * @property string $content
 */
class Recommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'er_recommend';
    }
    public function geter_recommendtype()
    {
        return $this->hasOne(Recommendtype::className(), ['type' => 'type']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'create_time'], 'required'],
            [['type', 'create_time', 'listorder'], 'integer'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['image', 'url'], 'string', 'max' => 200],
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
            'create_time' => 'Create Time',
            'listorder' => 'Listorder',
            'content' => 'Content',
        ];
    }
}
