<?php
namespace app\controllers;
use yii;
use lib\components\AdCommon;
use yii\base\Model;
use lib\wealth\Pinyin;
use lib\models\ActivityCenter;


//活动中心控制器
class ActivityCenterController extends TemplateController
{

    public $config = [
        'modelName' => 'lib\models\ActivityCenter',
        'modelShortName' => 'ActivityCenter',
        'listUrl' => 'ActivityCenterIndex',
        'addUrl' => 'ActivitycenterAdd',
       'delUrl' => 'ActivitycenterDel',
       'chgUrl' => 'ActivitycenterEdit',
        'addTitle' => '添加',
        'addFormName' => '参数',
        'chgTitle' => '修改',
        'chgFormName' => '参数',
        'listTitle' => '标签列表',
        'listFormName' => '参数',
    ];

    // 可搜索的选项
    public function getSearch()
    {
        return [

        ];
    }
    public function actionIndex()
    {
        $this->data['search'] = $this->getSearch();
        $this->setIndexData();
        $this->data['config'] = $this->config;
        $this->data['title'] = $this->getIndexField();
         return $this->view('../template/index');
    }

    //添加修改中定主的字段
    protected function getOption()
    {
        return [
            ['key'=>'title','value'=>'','html'=>'text','option'=>''],
            ['key'=>'url','value'=>'','html'=>'image','option'=>''],
            ['key'=>'s_dt','value'=>'','html'=>'time','option'=>''],
            ['key'=>'e_dt','value'=>'','html'=>'time','option'=>''],
        ];
    }


    //主页中显示的字段名
    public function getIndexField()
    {
        return [
            'iid',
            'title',
            'url',
            's_dt',
            'e_dt'
        ];
    }
}
?>