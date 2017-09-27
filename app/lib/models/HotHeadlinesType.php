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

    //取有效的列表数据
    public static function getValidList()
    {
        $result = HotHeadlinesType::getCacheList();
        $new_result = [];
        foreach($result as $row) {
            if($row['state']) {
                $new_result[] = [
                    'iid' => $row['iid'],
                    'name' => $row['name'],
                ];
            }
        }
        return $new_result;
    }

    //取有效的列表数据
    public static function getList($fields, $state=2)
    {
        $result = HotHeadlinesType::getCacheList();
        $new_result = [];
        foreach($result as $row) {
            $new_row = [];
            foreach($fields as $field) {
                if($state != 2 && $row['state'] != $state ) {
                    continue;
                }
                $new_row[$field] = $row[$field];
            }
            $new_result[] = $new_row;
        }
        return $new_result;
    }
}
