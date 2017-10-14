<?php
namespace lib\models;

use Yii;
use yii\db\ActiveRecord;
use yii\extend\AdCommon;
use yii\web\IdentityInterface;
use lib\wyim\wyim;
use lib\wealth\Diamond;
use lib\traits\tokenTrait;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord
{
    use tokenTrait;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_INITIALIZE = 1;

    public $userId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username', 'auth_key', 'wy_accid', 'wy_token'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            ['email', 'email'],
            [['diamond','wallet', 'reward_count'], 'number'],
            [['vip_start', 'vip_end'],'safe'],
            [['status', 'role', 'credits', 'agent', 'share_number', 'follow_number', 'fans_number', 'vip_type', 'live_telecast_status','is_robot'], 'integer'],
            ['head', 'string', 'max' => 100],
            ['nickname', 'string', 'max' => 15],
            [['name'], 'string', 'max' => 15],
            ['sex', 'in', 'range' => ['男', '女']],
            [['province', 'city'], 'string', 'max' => 7],
            [['llaccounts', 'inviteCode'], 'string', 'max' => 20],
            [['address', 'signature'], 'string', 'max' => 50],
            ['llaccounts', 'match', 'pattern'=>'/^[0-9A-Za-z]+$/','message'=>'联联号由字母和数字组成' ],
        ];
    }
    //通过ID取用户实例
    public static function findIdentity($id)
    {
        return static::findOne(['iid' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    //通过Token取用户实例
    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    //通过用户名取用户实例
    public static function findByUsername($username)
    {
        return static::find()
            ->where('username = :username AND status !=0 ', [':username' => $username])
            ->limit(1)
            ->one();
    }

    //通过邮箱取用户实例
    public static function findByEmail($username)
    {
        return static::find()
            ->where('email = :username AND status !=0 ', [':username' => $username])
            ->limit(1)
            ->one();
    }

    //通过联联帐号找实例
    public static function findByLlaccounts($llaccount)
    {

        return static::find()
            ->where('llaccounts = :llaccount AND status !=0 ', [':llaccount' => $llaccount])
            ->limit(1)
            ->one();
    }

    //取用户ID
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    

    //取代理信息
    public function getAgentinfo() {
        return $this->hasOne(Agent::className(),['iid'=>'agent']);
    }

    //取直播 信息
    public function getChannelinfo() {
        return $this->hasOne(Channel::className(), ['user_id'=>'iid']);
    }

    //取VIP信息
    public function getMemberinfo() {
        return $this->hasOne(Member::className(),['iid'=>'vip_type']);
    }


    public function countPrice() {
        return (string)(number_format($this->wallet + $this->diamond / \lib\models\Setting::keyTovalue('money2diamond') * 100,2));
    }


    //关联钻石表
    public function getDiamondinfo() {
        return $this->hasMany(UserDiamondLog::className(),['user_id'=>'iid']);
    }

    //登入
    public function login($account, $password)
    {

        if( AdCommon::isMobile($account) ) {
            $model = static::findByUsername( $account );
        } else {
            $model = static::findByLlaccounts( $account );
        }

        if( empty($model) || !$model->validatePassword($password) ) {
            throw new \Exception(Yii::t('common', 'password_error'));
        }
     
        if(HUANG_JING != 0)
        {
            $model->setToken();
            return $model->getLoginInfo();
        }
        else
        {
            Yii::$app->getSession()->set('userId', $model->iid);
            return true;
        }
    }

    //取登入信息
    public function getLoginInfo()
    {
        return [
            'userid'=>$this->iid,
            'token'=> $this->getToken(),
            'nickname' => $this->nickname,
            'llaccounts' => $this->llaccounts,
            'signature' => $this->signature,
            'fans_number' => $this->fans_number,
            'share_number' => $this->share_number,
            'follow_number' => $this->follow_number,
            'diamond' => $this->diamond,
            'head' => $this->get_head(),
            'is_vip' => $this->vip_type ? 1 : 0,
            'accountlevel'=>[
                "iid"=>"5",
                "name"=>"一级",
                "credits"=>"0",
                "withdrawal_proportion"=>"1"
            ],
            'wy_im_accid' => $this->wy_accid,
            'wy_im_token' => $this->wy_token,
            'inviteCode' => $this->inviteCode,
            'total_assets' => $this->countPrice(),
        ];
    }

    //取用户信息
    public function getinfo()
    {
        return [
            'head' => $this->get_head(),
            'nickname' => $this->nickname,
            'llaccounts' => $this->llaccounts,
            'signature' => $this->signature,
            'name' => $this->name,
            'sex' => $this->sex,
            'province' => $this->province,
            'city' => $this->city,
            'vip_type' => $this->vip_type,
            'fans_number' => $this->fans_number,
            'follow_number' => $this->follow_number,
            'wy_accid' => $this->wy_accid,
        ];
    }

    //检查权限
    public function checkPower($power)
    {
        if(!$this->vip_type) {
            return false;
        }

        $vip = Member::getCacheRow($this->vip_type);
        if(!$vip) {
            return false;
        }

        if(in_array($power,$vip['powers'])) {
            return true;
        } else {
            return false;
        }

    }

    //取头像路径
    public function get_head()
    {
        $head_arr = json_decode($this->head);

        if($head_arr && is_object($head_arr)) {
            if(empty($head_arr->group_name) ||  empty($head_arr->filename)) {
                $url = Yii::$app->params['webpath'] . '/uploads/default_head.png';
            } else {
                $server = Yii::$app->params['imgServer'][$head_arr->group_name] ?? '';
                $url = $server . $head_arr->group_name . '/' . $head_arr->filename;
            }
        } else {
            $url = $this->head;
        }
        return $url ?? '';
    }


    public static function get_head_url($head)
    {
        $head_arr = json_decode($head);

        if($head_arr && is_object($head_arr)) {
            if(empty($head_arr->group_name) ||  empty($head_arr->filename)) {
                $url = Yii::$app->params['webpath'] . '/uploads/default_head.png';
            } else {
                $server = Yii::$app->params['imgServer'][$head_arr->group_name] ?? '';
                $url = $server . $head_arr->group_name . '/' . $head_arr->filename;
            }
        } else {
            $url = $head;
        }
        return $url ?? '';
    }
    

    //修改密码
    public function changePassword($password) {
        $this->setPassword($password);
        if(!$this->save()) {
            throw new \Exception(AdCommon::modelMessage($this->errors));
        }
        return true;
    }

    //验证密码
    public function validatePassword($password)
    {
        if(HUANG_JING < 2 ) {
            return Yii::$app->security->validatePassword($password, $this->password_hash);
        } else {
            return hash_hmac('sha256',$password,'59617D9B-E370-419F-8CC9-F540CFDA8C84') == $this->password_hash;
        }
    }

    //设置密码
    public function setPassword($password)
    {
        if(HUANG_JING < 2) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        } else {
            $this->password_hash = hash_hmac('sha256',$password,'59617D9B-E370-419F-8CC9-F540CFDA8C84');
        }
    }

    //用户注册网易信息
    public function registerWyAccid()
    {
        $result = wyim::createAccid($this);
        if ( $result === false && isset(wyim::$error->code)) {
            switch(wyim::$error->code){
                case 414:   //用户已经注册更新wytoken
                        $result = wyim::refreshToken($this);
                    break;

                default:

                    return false;

            }
            //登记失败后处理方法
        }

        if($result) {
            $this->wy_token = $result->token;
            $this->wy_accid = $result->accid;
            $this->save();
        } else {
            return false;
        }

    }

    //更新网易IM信息
    public function updateWyImInfo($data)
    {

        $result = wyim::updateUinfo($data);
        if ($result === false) {
            //登记失败后处理方法
        } else {
            return true;
        }
    }

    //取上一级
    public function getTop()
    {
        if($this->inviteCode) {
            return $this->findOne(['llaccounts'=>$this->inviteCode]);
        }
        return false;
    }

    //取用户会员权限
    public function getMemberPower()
    {
        if($this->vip_type) {
            return Member::getCacheRow($this->vip_type);
        } else {
            return false;
        }
    }

}
