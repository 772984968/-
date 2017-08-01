<?php
namespace lib\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use lib\wyim\wyim;

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
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_INITIALIZE = 1;


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
            [['username','auth_key','wy_accid','wy_token'], 'string', 'max'=>32],
            [['password_hash','password_reset_token'], 'string', 'max'=>255],
            ['email' , 'email'],
            [['status', 'role','credits'], 'integer'],
            ['head','string','max'=>100],
            ['nickname','string','max'=>15],
            [['signature','name'],'string','max'=>15],
            ['sex','in','range'=> ['男','女']],
            [['province','city'],'string','max'=>7],
            ['llaccounts','string','max'=>20],
            ['address','string','max'=>50],
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
            ->where('username = :username AND status !=0 ',[':username'=>$username])
            ->limit(1)
            ->one();
    }

    //通过邮箱取用户实例
    public static function findByEmail($username)
    {
        return static::find()
            ->where('email = :username AND status !=0 ',[':username'=>$username])
            ->limit(1)
            ->one();
    }

    //通过联联帐号找实例
    public static function findByLlaccounts($username)
    {

        return static::find()
            ->where('llaccounts = :username AND status !=0 ',[':username'=>$username])
            ->limit(1)
            ->one();
    }

    //取用户ID
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    //取密码
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    //验证authkey是否正确
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    //验证密码
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    //设置密码
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    //创建authkey
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    //生成密码重置令牌
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    //消除密码重置令牌
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    //这个就是我们进行yii\filters\auth\QueryParamAuth调用认证的函数，下面会说到。
    public function loginByAccessToken($accessToken, $type) {
        //查询数据库中有没有存在这个token
        return static::findIdentityByAccessToken($accessToken, $type);
    }

    //用户注册网易信息
    public function registerWyAccid()
    {
        $user = [
            'username' => $this->username,
            'nickname' => $this->nickname,
            'head' => $this->head,
        ];
        $result = wyim::createAccid($user);
        if($result === false) {
            //登记失败后处理方法
        } else {
            $this->wy_token = $result->token;
            $this->wy_accid = $result->accid;
            $this->save();
        }
    }
    
    

}
