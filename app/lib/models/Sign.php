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
    public  function signin($iid){
        $signsetting= new Signsetting();//积分规则
        $sign=$this->find()->where(['user_id'=>$iid])->one();
      // $today=date('Ymd');//今天签到日期
        $today=strtotime(date('Ymd'));
        //不存在签到
        if(!$sign){
            $this->user_id=$iid;
            $this->last_signtime=$today;
            $this->total=1;
            $this->continue_day=0;
            $this->sign_day=1;
            $data=$signsetting->find()->where(['sign_day'=>1,'continue_day'=>0])->select('credits')->one();
            if ($data){
                $this->credits=$data->credits;
                $this->total_credits=$data->credits;
            }

            //开启事务
            $transaction=\Yii::$app->db->beginTransaction();
           try {
                //签到表
                if (!$this->save())
                    throw new \Exception();
                //签到记录表
                $signdate=new Signdate();
                if (!$signdate->insertdate($this->attributes['iid'],$today))
                    throw new \Exception();
                //用户表
                $user=User::find()->where(['iid'=>$iid])->one();
                $user->credits=$user->credits+$data->credits;
                if (!$user->save())
                   throw new \Exception();
                $transaction->commit();
                return true;
            }catch (\Exception $e){
                $transaction->rollBack();
                $this->addError('user_id',$e->getMessage());
                return false;
            }
       }
        //存在
        else{

            $last_day=$sign->last_signtime;
            //判断今天是否签到
            if ($last_day==$today){
                $this->addError('user_id','今天已经签到过了');
                 return false;
            }
      if (($today-$last_day)<=86400){
                //小于一天，连续签到
                  $sign_day=$sign->sign_day+1;
                  $rs=$signsetting->find()->where(['sign_day'=>$sign_day,'continue_day'=>0])->orWhere(['and','sign_day<='.$sign_day,'continue_day=1'])->select('credits')->one();
                $sign->sign_day=$sign->sign_day+1;
                $key=1;
        }
            else{
                //非连续签到
                $rs=$signsetting->find()->where(['sign_day'=>1,'continue_day'=>0])->select('credits')->one();
                $sign->sign_day=1;
                $sign->continue_day=$sign->continue_day+1;
                $key=0;
            }
            $sign->total=$sign->total+1;
            $sign->last_signtime=$today;
            if ($rs){
                $sign->credits=$rs->credits;
                $sign->total_credits=$sign->total_credits+$rs->credits;
            }


            //开启事务
            $transaction=\Yii::$app->db->beginTransaction();
            try {
                //签到表
                if (!$sign->save())
                    throw new \Exception();
                    //签到记录表
                    $signdate=new Signdate();
                    if (!$signdate->insertdate($sign->iid,$today,$key))
                        throw new \Exception();
                        //用户表
                        $user=User::find()->where(['iid'=>$iid])->one();
                        $user->credits=$user->credits+$rs->credits;
                        if (!$user->save())
                            throw new \Exception();
                            $transaction->commit();
                            return true;
            }catch (\Exception $e){
                $transaction->rollBack();
                $this->addError('user_id',$e->getMessage());
                return false;
            }
        }

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