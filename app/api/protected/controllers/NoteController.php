<?phpnamespace api\controllers;use Yii;use lib\forms\NoteForm;use lib\forms\EmailForm;use yii\extend\AdCommon;class NoteController extends BasisController{    public function actionRegister()    {        $usrename = Yii::$app->getRequest()->post('username');        if( AdCommon::isMobile( $usrename ) ) {            $model = new NoteForm();        } else {            $this->error('帐号需为手机号码!');        }        $model->setScenario('register');        $model->username = $usrename;        if( $model->register() ) {            $this->success('','验证码发送成功,有效时间'.$model->validMinute.'分钟');        } else {            $this->error( $this->modelMessage( $model->errors ) );        }    }    /**     * @author li     * 找回密码发送短信     */  public function actionFind(){      $username=Yii::$app->getRequest()->post('username');      if (!AdCommon::isMobile($username)){         $this->error('账号需为手机号');      }      $model = new NoteForm();      $model->setScenario('find');      $model->username = $username;     if( $model->findpassword() ) {          $this->success('','验证码发送成功,有效时间'.$model->validMinute.'分钟');      } else {          $this->error( $this->modelMessage( $model->errors ) );      }  } public function actionCheckRegister()    {        $rq = Yii::$app->getRequest();        $username = $rq->post('username');        $captcha = $rq->post('captcha');        $inviteCode = $rq->post('inviteCode');        if(!$username || !$captcha) {            $this->error('参数错误');        }        /*if(!$inviteCode) {            $this->error('推荐人联联号不能为空');        }        if(!\lib\models\User::findOne(['llaccounts'=>$inviteCode])) {            $this->error('推荐人联联号不存在');        }*/        if($inviteCode && !\lib\models\User::findOne(['llaccounts'=>$inviteCode])) {            $this->error('推荐人联联号不存在');        }        if(\lib\forms\NoteForm::checkRegister($username, $captcha)) {            $this->success();        } else {            $this->error('验证码错误!');        }    }}