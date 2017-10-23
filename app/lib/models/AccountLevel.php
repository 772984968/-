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
            [['credits', 'withdrawal_proportion','diamond_proportion'], 'integer'],
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


    public static function getLevel($credits)
    {
        $data = static::getCacheList();
        foreach($data as $key => $row)
        {
            if($credits >= $row['credits']) {
                return $row['name'];
            }
        }
    }
    //直播收益返回等级比例
    public  static  function liveearn($credits){
        $level=self::getLevel($credits);
        $AccountLevel=self::find()->where('iid>0')->asArray()->all();
        $levels=array_column($AccountLevel,'name');
        if (in_array($level,$levels)){
            foreach ($AccountLevel as $key=>$value){
                if ($value['name']==$level){
                    $withdrawal_proportion=bcdiv($value['withdrawal_proportion'],100,3);//等级钻石提现比例
                }
            }
               return  $withdrawal_proportion;
        }

        return 0;

    }
    //钻石提现返回等级比例
    public  static function diamondWithdraw($credits){
        $level=self::getLevel($credits);
        $AccountLevel=self::find()->where('iid>0')->asArray()->all();
        $levels=array_column($AccountLevel,'name');
        if (in_array($level,$levels)){
            foreach ($AccountLevel as $key=>$value){
                if ($value['name']==$level){
                    $withdrawal_proportion=bcdiv($value['diamond_proportion'],1000,3);//等级钻石提现比例
                }
            }
            return  $withdrawal_proportion;
        }
        return 0;
    }


}
