<?php

namespace lib\models;

use Yii;
use lib\traits\operateDbTrait;
/**
 * This is the model class for table "vip_video".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $price
 * @property string $vip_price
 * @property string $cover
 * @property string $thumbnail
 * @property string $url
 * @property integer $date
 * @property string $watch_count
 * @property string $like_count
 * @property string $wy_name
 * @property integer $wy_vid
 * @property string $local_address
 * @property integer $status
 */
class VipVideo extends \yii\db\ActiveRecord
{
    use operateDbTrait;
    public static function getDb()
    {
        return Yii::$app->dbyh;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vip_video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['price', 'vip_price'], 'number'],
            [['date', 'watch_count', 'like_count', 'wy_vid', 'upload_status'], 'integer'],
            [['title', 'cover'], 'string', 'max' => 1024],
            [['thumbnail', 'url'], 'string', 'max' => 2048],
            [['wy_name', 'local_address'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'description' => 'Description',
            'price' => 'Price',
            'vip_price' => 'Vip Price',
            'cover' => 'Cover',
            'thumbnail' => 'Thumbnail',
            'url' => 'Url',
            'date' => 'Date',
            'watch_count' => 'Watch Count',
            'like_count' => 'Like Count',
            'wy_name' => 'Wy Name',
            'wy_vid' => 'Wy Vid',
            'local_address' => 'Local Address',
            'upload_status' => 'upload_status',
        ];
    }

}
