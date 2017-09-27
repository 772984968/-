<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_signsetting".
 *
 * @property integer $iid
 * @property integer $sign_day
 * @property integer $credits
 * @property integer $continue_day
 */
class Signsetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_signsetting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iid', 'sign_day', 'credits','continue_day'], 'integer'],
            [['sign_day', 'credits'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'sign_day' => ' Sign Day',
            'credits' => 'Credits',
            'continue_day' => 'Contiue day',

        ];
    }
}
