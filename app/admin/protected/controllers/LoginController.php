<?php
/**
 *
 * @Copyright (C), 2014-03-26, Alisa.
 * @Name LoginController.php
 * @Author Alisa
 * @Version  Beta 1.0
 *
 **/
namespace app\controllers;

use Yii;
use app\controllers\BasicsController;
use app\library\AdminLibrary;

class LoginController extends BasicsController
{
    /**
     * [actionIndex description]
     * @return [type] [description]
     */
    public function actionIndex()
    {
        if (!empty(\Yii::$app->session['admin']))
        {
            $this->redirect(\Yii::$app->params['url']['main']);
        }
        if($this->isPost()) {
            if($this->createAction('captcha')->validate($this->post('captcha'),false)) {
                $data = ['account' => $this->post('username'), 'pwd' => $this->post('password')];
                $result = AdminLibrary::APP()->login($data);
                if ($result['status'] == 0) {
                    echo '<script>top.location.href=\''.\yii\helpers\Url::toRoute([\Yii::$app->params['url']['main']]).'\'</script>';exit();
                    //$this->redirect(\Yii::$app->params['url']['main']);
                } else {
                    $this->data['error'] = $result['msg'];
                }
            } else {
                $this->data['error'] = \Yii::t('app', 'captcha');
            }
        }

       return $this->view();
    }

    /**
     * [actionOut 退出登录]
     * @return [type] [description]
     */
    public function actionOut()
    {
        unset(\Yii::$app->session['admin']);
        $this->redirect(\Yii::$app->params['url']['login']);
    }

    /**
     * [actions 验证码]
     * @return [type] [null]
     */
    public function actions()
    {
        ob_clean();
        parent::actions();
        return [
                'captcha' => [
                    'class' => 'yii\captcha\CaptchaAction',
                    'backColor' => 0xE1E1E1,
                    'foreColor' => 0x1d70d8,
                    'maxLength' => '4', // 最多生成几个字符
                    'minLength' => '4', // 最少生成几个字符
                    'width' => '100',
                    'height' => '35',
                    'padding' => 0,
                ],
        ];
    }

    /**
     * 错误处理
     * @author kevin
     * @return type
     */
    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['message' => $exception]);
        }
    }
}