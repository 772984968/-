<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_account_level".
 *
 * @property integer $iid
 * @property string $name
 * @property integer $credits
 * @property integer $withdrawal_proportion
 */
class AccountLevel extends BaseModel
{
    const LIST_CACHE_NAME = 'Account_Level_list';
    const NUMBER_NAME = 'credits';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_account_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['credits', 'withdrawal_proportion'], 'integer'],
            [['name'], 'string', 'max' => 10],
            [['name'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'name' => Yii::t('common','name'),
            'credits' => Yii::t('common','credits'),
            'withdrawal_proportion' => Yii::t('common','withdrawal_proportion'),
        ];
    }
    
}
