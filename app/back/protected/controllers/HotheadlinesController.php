<?phpnamespace app\controllers;use yii\web\Controller;use lib\news\HotHeadlines;use Yii;class HotheadlinesController extends Controller{    //抓取数据    public function actionGrablist()    {        $result = HotHeadlines::getList();    }    }