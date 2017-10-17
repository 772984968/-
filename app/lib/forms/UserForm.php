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
            [['username', 'password', 'captcha', 'user_id', 'inviteCode'], 'required'],
            [['nickname'], 'required' , 'on' => 'register'],
            [['username', 'captcha', 'password'],'string','max'=>32],
            ['head', 'headToUrl'],
            ['inviteCode', 'validateInviteCode'],
            ['llaccounts', 'unique', 'targetClass' => '\lib\models\User', 'message' => '联联号已经注册。'],
            ['username', 'unique', 'targetClass' => '\lib\models\User', 'message' => '帐号已经注册。','on'=>['register']],
            ['captcha','validateCode','on'=>'register'],//
            ['captcha','validateCode2','on'=>'msgpassword'],
            ['llaccounts', 'match', 'pattern'=>'/^[0-9A-Za-z]+$/','message'=>'联联号由字母和数字组成','on'=>['register'] ],
//          [['user_id','time'], 'required' , 'on' => 'sign'],

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
            $head = UploadForm::savebase64tofile($this->head);
            if($head)
            {
                $img = new \yii\extend\Image($head,pathinfo($head, PATHINFO_EXTENSION));
                $img->noopsyche(500,500);   //裁剪图片
                $head_is = json_encode(fastdfs_storage_upload_by_filename($head)); //保存到图片服务器
                if($head_is) {
                    $this->head = $head_is;
                    return;
                }
                unlink($head);  //删除文件
            }
            $this->addError('head', '头像上传失败,请稍候再试');
            return false;
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
            $className = '\lib\forms\NoteForm';
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
                \lib\models\ActivityReward::$userModel = $model;
                \lib\models\ActivityReward::get('register');        //获取注册优惠
                $this->setScenario('login');                        //登入
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

            $rst = Yii::$app->factory->createuser()->login($this->username, $this->password);
            return $rst;
        }
    }

    public function changepassword()
    {

        if( $this->validate() )
        {
            return Yii::$app->factory->getuser()->changePassword( $this->password );
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
        {
            $model= Yii::$app->factory->createuser()->findByUsername($this->username);
            return $model->changePassword( $this->password );
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
