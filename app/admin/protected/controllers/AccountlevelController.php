<?phpnamespace app\controllers;use lib\models\AccountLevel;use yii;//帐号等级类class AccountlevelController extends TemplateController{    public $config = [        'modelName' => 'lib\models\AccountLevel',        'modelShortName' => 'AccountLevel',        'listUrl' => 'AccountLevel',        'addUrl' => 'AccountLevelAdd',        'delUrl' => 'AccountLevelDel',        'chgUrl' => 'AccountLevelEdit',        'addTitle' => '添加',        'addFormName' => '参数',        'chgTitle' => '修改',        'chgFormName' => '参数',        'listTitle' => '标签列表',        'listFormName' => '参数',    ];    //可搜索的选项    public function getSearch()    {        return [        ];    }    //添加修改中定主的字段    protected function getOption()    {        return [            ['key'=>'name','value'=>'','html'=>'text','option'=>''],            ['key'=>'credits','value'=>'','html'=>'text','option'=>''],            ['key'=>'withdrawal_proportion','value'=>'','html'=>'text','option'=>''],        ];    }    //主页中显示的字段名    public function getIndexField()    {        return [            'iid',            'name',            'credits',            'withdrawal_proportion'        ];    }}?>