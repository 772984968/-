<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_member_price".
 *
 * @property integer $iid
 * @property integer $member_id
 * @property integer $mos
 * @property string $price
 * @property string $notes
 * @property string $create_time
 */
class MemberPrice extends BaseModel
{
    const LIST_CACHE_NAME = 'member_price_list';
    const NUMBER_NAME = 'mos';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_member_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'mos'], 'integer'],
            [['price'], 'number'],
            [['create_time'], 'safe'],
            [['notes'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'member_id' => 'Member ID',
            'mos' => 'Mos',
            'price' => 'Price',
            'notes' => 'Notes',
            'create_time' => 'Create Time',
        ];
    }
}
