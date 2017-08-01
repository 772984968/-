<?php
namespace app\controllers;
use lib\models\Feedback;
use app\controllers\SellerController;

//信息反馈
class FeedbackController extends SellerController
{
    public $_article;
    public function init()
    {
        parent::init();
        $this->_article = new Feedback();
    }
    public function actionIndex(){

        $query = $this->query($this->_article ,'', 1,'feedback_id DESC');
        $this->data['count'] = $query['count'];
        $this->data['data']  = $query['data'];
        $this->data['page']  = $query['page'];
        return $this->view('index');
    }

    public function actionDel()
    {
        $id = $this->post('data');
        if (empty($id)) $this->error(\yii::t('app', 'error'));
        $info = Feedback::findOne($id);
        $result = $info->delete();
        if ($result)
        {
            $this->success(\yii::t('app', '删除成功'));
        } else
        {
            $this->error(\yii::t('app', '删除失败'));
        }
    }

}

?>

