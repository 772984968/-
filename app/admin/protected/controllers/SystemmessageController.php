<?php
namespace app\controllers;
use Yii;
use app\controllers\SellerController;
use lib\components\AdCommon;
use lib\models\SystemMessage;


class SystemmessageController extends SellerController
{
    private $_article;
    public function init()
    {
        parent::init();
        $this->_article = new SystemMessage();
    }

    public function actionIndex(){
        $query = $this->query($this->_article ,'', 1,'message_id DESC');
        $this->data['count'] = $query['count'];
        $this->data['data']  = $query['data'];
        $this->data['page']  = $query['page'];
        return $this->view('index');
    }

    public function actionAdd()
    {
        $ads = new SystemMessage();
        if ($this->isPost())
        {
            $post = $this->post('SystemMessage');
            $post['create_time'] =time();
            $ads->attributes = $post;
            $ads->save();
            if (empty($ads->errors)) {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['systemmessage']);
            } else {
                $this->error(AdCommon::modelMessage($ads->errors));
            }
        }

        $this->data['model'] = $ads;
        return $this->view('window');
    }

    public function actionUpdate()
    {
        $id = $this->get('id');
        $ad = SystemMessage::findOne($id);
        if ($this->isPost())
        {
            $post = $this->post('SystemMessage');
            $ad->attributes = $post;
            $ad->save();
            if (empty($ad->errors))
            {
                $this->success(\yii::t('app', 'success'), \yii::$app->params['url']['systemmessage']);
            }
            else
            {
                $this->error(AdCommon::modelMessage($ad->errors));
            }
        }
        $this->data['model'] = $ad;
        return $this->view('window');
    }


    public function actionDel()
    {
        $id = $this->post('data');
        if (empty($id)) $this->error(\yii::t('app', 'error'));
        $result = SystemMessage::findOne($id)->delete();
        if ($result)
        {
            $this->success(\yii::t('app', 'success'));
        }
        else
        {
            $this->error(\yii::t('app', 'fail'));
        }
    }

}