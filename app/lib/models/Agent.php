<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_agent".
 *
 * @property integer $iid
 * @property string $name
 * @property integer $vip_reward
 * @property integer $recharge_reward
 */
class Agent extends BaseModel
{
    const LIST_CACHE_NAME = 'agent_cache_list_';
    const NUMBER_NAME = 'label';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_agent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_reward', 'recharge_reward', 'label'], 'integer'],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'name' => 'Name',
            'vip_reward' => 'Vip Reward',
            'recharge_reward' => 'Recharge Reward',
        ];
    }
}
