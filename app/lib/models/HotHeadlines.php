<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_hot_headlines".
 *
 * @property integer $iid
 * @property integer $type_id
 * @property string $title
 * @property string $author_name
 * @property string $other_id
 * @property string $source
 * @property string $images
 * @property string $content
 * @property string $url
 * @property string $source_time
 * @property string $create_time
 */
class HotHeadlines extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_hot_headlines';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'integer'],
            [['images', 'content', 'source_time'], 'required'],
            [['images', 'content'], 'string'],
            [['source_time', 'create_time'], 'safe'],
            [['title'], 'string', 'max' => 30],
            [['author_name', 'source'], 'string', 'max' => 20],
            [['other_id'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'type_id' => 'Type ID',
            'title' => 'Title',
            'author_name' => 'Author Name',
            'other_id' => 'Other ID',
            'source' => 'Source',
            'images' => 'Images',
            'content' => 'Content',
            'url' => 'Url',
            'source_time' => 'Source Time',
            'create_time' => 'Create Time',
        ];
    }

    public static function getList($page)
    {
        if($page['direction'] == 'down') {
            $where = 'iid<'.$page['id'];
        } else {
            $where = 'iid>'.$page['id'];
        }
        $data = static::find()
            ->select('iid,title,images,source_time')
            ->where($where)
            ->limit($page['pagesize'])
            ->orderBy('iid DESC')
            ->asArray()
            ->all();
        $maxIid = $data[0]['iid'] ?? 0;
        $minIid = $data[count($data)-1]['iid'] ?? 0;

        return ['maxIid' => $maxIid, 'minIid' => $minIid, 'data' => $data];
    }
}
