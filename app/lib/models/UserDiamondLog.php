<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "at_user_diamond_log".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property integer $type
 * @property string $number
 * @property integer $source_user_id
 * @property string $note
 */
class UserDiamondLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_user_diamond_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'source_user_id'], 'integer'],
            [['number'], 'number'],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'user_id' => 'User ID',
            'type' => 'Type',
            'number' => 'Number',
            'source_user_id' => 'Source User ID',
            'note' => 'Note',
        ];
    }

    public static function add( array $data )
    {
        $model = new static();

        foreach($data as $key => $value)
        {
            $model->$key = $value;
        }

        if( $model->save() ) {
            return $model->iid;
        } else {
            return false;
        }
    }
    
    //求和
    public static function sum($id){
        $model=new UserDiamondLog;
        return $model::find()->where(['user_id'=>$id,'type'=>0])->sum('number');
             
    }
    
}
