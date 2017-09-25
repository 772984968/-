<?php


namespace lib\models;
use Yii;
use yii\extend\AdCommon;
use yii\mongodb\Database;
/**
 * This is the model class for table "at_signdate"
 *
 * @property integer $iid
 * @property integer $sign_id
 * @property integer $year
 * @property integer $month
 * @property integer $day
 */
class Signdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_signdate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['sign_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'sign_id' => ' Sign ID',
            'year' => 'Year',
            'month' => 'Month',
            'day' => 'Day',
            'total_mon'=>'Total mon',
            'sign_day'=>' Sign_day'
       ];
    }
    public function insertdate($sign_id,$time,$key=0){
        $year=date('Y',$time);
        $month=date('m',$time);
        $day=date('d',$time);
        $model=$this->find()->where(['year'=>$year,'month'=>$month])->one();
        if ($model){
            $model->sign_id=$sign_id;
            $model->year=$year;
            $model->month=$month;
            $model->day=$model->day.','.$day;
            $model->total_mon=$model->total_mon+1;
            if ($key==1)
            {
                $model->sign_day=$model->sign_day+1;
            }else{
                $model->sign_day=1;
            }
            if ($model->save()){
                return true;
            }else{
                return false;
            }
        }else{
            $this->sign_id=$sign_id;
            $this->year=$year;
            $this->month=$month;
            $this->day=$day;
            $this->total_mon=1;
            $this->sign_day=1;
            if ($this->save()){
                return true;
            }else{
                return false;

            }

        }


    }

}