<?php


namespace lib\models;
use Yii;
/**
 * This is the model class for table "at_sign".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property integer $last_signtime
 * @property integer $total
 * @property integer $continue_day
 * @property integer $sign_day
 */
class Sign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_sign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iid', 'user_id', 'last_signtime','continue_day','total','sign_day','credits','total_credits'], 'integer'],
            [['user_id','last_signtime','continue_day', 'sign_day','total'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'user_id' => ' User ID',
            'continue_day' => 'Continue Day',
            'last_signtime' => 'Last Sign Time',
            'total' => 'Total',
            'sign_day' => ' Sign Day',
            'credits'=>'Credits',
            'total_credits'=>'Total Credits',

        ];
    }
    //获取签到日期详情
    public  function signlist($user_id,$year,$month){
        $data=$this->find()->where(['user_id'=>$user_id])
        ->select('iid,user_id,total,credits,last_signtime')
        ->with([
            'signdate'=>function($query) use($month,$year) {
                  $query->where(['year'=>$year,'month'=>$month]);
            }
        ])
        ->asArray()->all();
        return $data;

    }
    //关联签到日期表
    public function getsigndate() {
        return $this->hasMany(Signdate::className(),['sign_id'=>'iid'])
         ->select('sign_id,year,month,day,total_mon');
    }
    //关联签用户表
    public function getuserinfo() {
        return $this->hasOne(User::className(),['iid'=>'user_id'])
        ->select('username');
    }













}