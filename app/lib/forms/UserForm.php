<?php
namespace lib\forms;
use Yii;
use yii\base\Model;
use yii\extend\AdCommon;
use lib\models\User;

class UserForm extends Model
{
    public $username;       //账号
    public $password;       //密码
    public $captcha;        //验证码

    public $user_id;
    public $head;
    public $nickname;
    public $llaccounts;
    public $signature;
    public $name;
    public $sex;
    public $province;
    public $city;

    public function scenarios()
    {
        return [
            'register' => [
                'username',
                'password',
                'captcha',
            ],
            'login' => [
                'username',
                'password',
            ],
            'changepassword' => [
                'password'
            ],
            'updateinfo' => [
                'user_id',
                'head',
                'nickname',
                'llaccounts',
                'signature',
                'name',
                'sex',
                'province',
                'city',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'captcha', 'user_id'], 'required'],
            [['username', 'captcha', 'password'],'string','max'=>32],
            [['name'], 'string', 'max' => 2],
            ['head', 'headToUrl'],
            ['llaccounts', 'unique', 'targetClass' => '\lib\models\User', 'message' => '联联号已经注册。'],
            ['username', 'unique', 'targetClass' => '\lib\models\User', 'message' => '帐号已经注册。','on'=>['register']],
            ['captcha','validateCode'],
        ];
    }


    public function headToUrl($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            //$this->
        }
    }

    public function validateCode($attribute, $params)
    {
        if (!$this->hasErrors()) {

            if(AdCommon::isMobile( $this->username )) {
                $className = '\lib\forms\NoteForm';
            } else {
                $this->addError($attribute, '用户名需为手机号码!');
                return false;
            }

            if( !$className::checkRegister($this->username, $this->captcha)) {
                $this->addError($attribute, Yii::t('common','sms_captcha_error'));
                return false;
            }
        }
    }

    public function register()
    {
        if( $this->validate() )
        {
            $model = new User();
            $model->username = $this->username;
            $model->setPassword( $this->password );
         
            if( $model->save() ) {
                $model->registerWyAccid();
                return true;
            } else {
                $this->addError('name',AdCommon::modelMessage($model->errors));
                return false;
            }
        }
    }

    public function login()
    {
        if( $this->validate() )
        {
            if( AdCommon::isMobile($this->username) ) {
                $model = User::findByUsername( $this->username );
            } elseif( AdCommon::isEmail($this->username) ) {
                $model = User::findByEmail( $this->username );
            } else {
                $model = User::findByLlaccounts( $this->username );
            }

            if( empty($model) || !$model->validatePassword($this->password) ) {
                $this->addError('username',Yii::t('common', 'password_error'));
                return false;
            }


            if(HUANG_JING != 0)
            {
                $user = Yii::$app->factory->getuser();
                $user->login( $model );
                return [
                    'userid'=>$model->iid,
                    'token'=>$user->getToken(),
                    'accountlevel'=>$user->getAccountLevel(),
                    'wy_im_accid' => $model->wy_accid,
                    'wy_im_token' => $model->wy_token,
                ];
            }
            else
            {
                Yii::$app->getSession()->set('userId', $model->iid);
                $user = Yii::$app->factory->getuser();
                $user->login( $model );
                return true;
            }


        }
    }

    public function changepassword()
    {
  
        if( $this->validate() )
        {
            $model = Yii::$app->factory->getuser()->getIdentity();
            
            $model->setPassword( $this->password );

            if( $model->save() ) {
                return true;
            } else {
                $this->addError('username', AdCommon::modelMessage($model));
                return false;
            }
        }
    }

    public function updateinfo()
    {
        if($this->validate())
        {
            echo $this->sex;
            return true;
        }
    }
}
