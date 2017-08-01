<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_hot_headlines_type".
 *
 * @property integer $iid
 * @property string $name
 * @property string $name_headline
 * @property integer $state
 * @property string $notes
 * @property string $create_time
 */
class HotHeadlinesType extends BaseModel
{
    const LIST_CACHE_NAME = 'hot_headlines_type_cache_';
    const NUMBER_NAME = 'order';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_hot_headlines_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name','required'],
            [['state','order'], 'integer'],
            [['name'], 'string', 'max' => 10],
            [['name_headline'], 'string', 'max' => 20],
            [['notes'], 'string', 'max' => 50],
            ['order','default','value'=>0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'name_headline' => 'Name Headline',
            'state' => 'State',
            'order' => 'order',
            'notes' => 'Notes',
        ];
    }
}
