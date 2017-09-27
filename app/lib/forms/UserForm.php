<?php
namespace lib\forms;
use lib\vendor\imagine\Filter\Basic\Paste;
use Yii;
use yii\base\Model;
use yii\extend\AdCommon;
use lib\models\User;

class UserForm extends Model
{
    public $username;       //账号
    public $password;       //密码
    public $captcha;        //验证码
    public $inviteCode;     //邀请码

    public $user_id;
    public $head;
    public $nickname;
    public $llaccounts;
    public $signature;
    public $name;
    public $sex;
    public $province;
    public $city;
  //  public $time;

    public function scenarios()
    {
        return [
            'register' => [
                'username',
                'password',
                'captcha',
                'llaccounts',
                'nickname',
                'inviteCode',
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
                'signature',
                'name',
                'sex',
                'province',
                'city',
            ],
            'msgpassword' => [
                'username',
                'captcha',
                'password',
            ],
            'emailpassword' => [
                'username',
                'captcha',
                'password',
            ],
           'encryptedpassword' => [
                'username',
                'captcha',
                'password',
            ],
            'sign'=>[
                'user_id',

            ]
       ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'captcha', 'user_id'], 'required'],
            [['nickname'], 'required' , 'on' => 'register'],
            [['username', 'captcha', 'password'],'string','max'=>32],
            ['head', 'headToUrl'],
            ['inviteCode', 'validateInviteCode'],
            ['llaccounts', 'unique', 'targetClass' => '\lib\models\User', 'message' => '联联号已经注册。'],
            ['username', 'unique', 'targetClass' => '\lib\models\User', 'message' => '帐号已经注册。','on'=>['register']],
            ['captcha','validateCode','on'=>'register'],//
            ['captcha','validateCode2','on'=>'msgpassword'],
//             [['user_id','time'], 'required' , 'on' => 'sign'],



        ];
    }

    public function attributeLabels()
    {
        return [
            'inviteCode' => '缴请码',
        ];
    }

    public function validateInviteCode($attribute, $params)
    {
        if(!$this->hasErrors()){
            if(!User::findOne(['llaccounts'=>$this->inviteCode])) {
                $this->addError($attribute, '邀请码输入不存在');
                return false;
            }
        }
    }

    public function headToUrl($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            $this->head = UploadForm::savebase64tofile($this->head);

            $img = new \yii\extend\Image($this->head,pathinfo($this->head, PATHINFO_EXTENSION));
            $img->noopsyche(50,50);
            $this->head = json_encode(fastdfs_storage_upload_by_filename($this->head));
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
/**
 * 验证码找回密码  li
 * @return boolean
 */
    public function validateCode2($attribute, $params)
    {

        if (!$this->hasErrors()) {
            if(AdCommon::isMobile( $this->username )) {
                $className = '\lib\forms\NoteForm';
            } else {
                $this->addError($attribute, '用户名需为手机号码!');
                return false;
            }
            $model = new User();
           if (!$model->findOne(['username'=>$this->username])){
               $this->addError($attribute, '不存在该用户');
            }
                if( !$className::checkfindpassword($this->username, $this->captcha)) {
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
            $model->attributes = AdCommon::array_clear_null($this->attributes);
            $model->head = Yii::$app->params['webpath'] . '/uploads/default_head.png';
            $model->setPassword( $this->password );

            if( $model->save() ) {
                $model->registerWyAccid();      //注册网易IM

                $this->setScenario('login');    //登入
                $result = $this->login();
                return $result;
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
                    'nickname' => $model->nickname,
                    'llaccounts' => $model->llaccounts,
                    'signature' => $model->signature,
                    'fans_number' => $model->fans_number,
                    'share_number' => $model->share_number,
                    'follow_number' => $model->follow_number,
                    'diamond' => $model->diamond,
                    'head' => \lib\nodes\UserNode::get_head_url($model->head),
                    'is_vip' => $model->vip_type ? 1 : 0,
                    'accountlevel'=>$user->getAccountLevel(),
                    'wy_im_accid' => $model->wy_accid,
                    'wy_im_token' => $model->wy_token,
                    'inviteCode' => $model->inviteCode,
                    'total_assets' => $model->countPrice(),
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
        /**
     * @author li
     * @return boolean
     * 找回密码
     */
    public function msgpassword()
    {

        if( $this->validate() )
        {   $model=User::findOne(['username'=>$this->username]);
            $model->setPassword( $this->password );
            if($model->save()) {
                return true;
            } else {
                $this->addError('username', AdCommon::modelMessage($model));
                return false;
            }
        }
    }
    /**
     * @author li
     * @return boolean
     * 签到
     */
    public function sign()
    {

        if( $this->validate() )
        {

            $className = '\lib\models\Sign';
            $signModel=new $className();
            if(!$signModel->signin($this->user_id))
            {
                $this->addError('user_id',\yii\extend\AdCommon::modelMessage($signModel->errors));
                return false;
           }
           //积分写到用户表
           return true;

        }
    }


    public function updateinfo()
    {
        if($this->validate())
        {
            $userModel = User::findOne($this->user_id);
            $userModel->attributes = AdCommon::array_clear_null($this->attributes);

            if( $userModel->save() ) {
                $url = \lib\nodes\UserNode::get_head_url($userModel->head);
                if($this->head || $this->nickname) {
                    \lib\wyim\wyim::updateUinfo($userModel);
                }
                return ['head'=> $url];
            } else {
                $this->addError('iid', AdCommon::modelMessage($userModel->errors));
                return false;
            }
        }
    }
}
