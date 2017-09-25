<?php 
namespace app\controllers;
use lib\models\Label;
use yii;

//标签类
class LabelController extends TemplateController
{
    public $config = [
        'modelName' => 'lib\models\Adminlabel',
        'modelShortName' => 'Adminlabel',
        'listUrl' => 'adminlabel',
        'addUrl' => 'AddLabel',
        'delUrl' => 'DelLabel',
        'chgUrl' => 'ChangeLabel',
        'addTitle' => '添加',
        'addFormName' => '参数',
        'chgTitle' => '修改',
        'chgFormName' => '参数',
        'listTitle' => '标签列表',
        'listFormName' => '参数',
    ];


    //可搜索的选项
    public function getSearch()
    {  
        return [
            'name' => '名称',
            'image' => '图片',
            'create_time' => '创建时间',
        ];
    }
    
    //添加修改中定主的字段
    protected function getOption()
    {
        return [
            ['key'=>'name','value'=>'','html'=>'text','option'=>''],
            ['key'=>'image','value'=>'','html'=>'image','option'=>''],
            ['key'=>'textarea','value'=>'','html'=>'textarea','option'=>''],
            ['key'=>'texts','value'=>'','html'=>'texts','option'=>''],
            ['key'=>'create_time','value'=>'','html'=>'time','option'=>''],
            ['key'=>'update_time','value'=>'','html'=>'time','option'=>''],
            ['key'=>'radio1','value'=>'','html'=>'radio','option'=>['中'=>'中','轼'=>'轼']],
            ['key'=>'select1','value'=>'','html'=>'select','option'=>['中'=>'中','轼'=>'轼']],
            ['key'=>'name2','value'=>'','html'=>'text','option'=>''],

        ];
    }


    //主页中显示的字段名
    public function getIndexField()
    {
        return [
            'name',
        ];
    }



}
?>