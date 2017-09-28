<?phpnamespace api\controllers;use Yii;use yii\web\Controller;class stdClass{};class BasisController extends Controller{    public $enableCsrfValidation = false;    const KEY = 'QVd+VLZ8z^M~r9G0MWAP2I#I]V-QAudE8F7mNgGuYcOi#pl$E8@b7Qi,p)tb].^GpH055ql$HoU!8[B]OI9sU5N+Mzs6,gvxg*FvuCrZahYNBW$n%$[FbI]yB[WmsN0x';    public function init()    {        $method = $this->module->requestedRoute;        //取控制器方法  例如 user/login        $method = $method ? $method : 'index/index';        //取控制器        if(!strpos($method,'/')) {   //没有输入方法的时候 例如  user            $method .=  '/index';        }        //线上，抓到 php://input 中的数据，解释成数组放到入 post 中        if(HUANG_JING >= 1) {            $post = file_get_contents("php://input");            if ($post && $post = $this->jsonToArray($post)) {                Yii::$app->getRequest()->setBodyParams($post);            }        }        //需要验证,签名        if(HUANG_JING > 3) {            $md5_sign = Yii::$app->getRequest()->post('md5_sign');            //验证签名环境            if( empty($md5_sign) ) {                Yii::$app->getRequest()->setBodyParams([]);            } else {                unset($post['md5_sign']);                $md5_sign_string = $this->createSign( $post );                if($md5_sign != $md5_sign_string) {                    $this->error('签名错误','401');                }            }        }        if( in_array($method,$this->noLoginMethod()) ) {            return true;        }        $factory = Yii::$app->factory;        //线上方式        if( HUANG_JING >= 1 ) {            $userid = Yii::$app->getRequest()->get('userid');            $token = Yii::$app->getRequest()->get('token');            if( !($userid && $token && $factory->getuser()->loginByToken($token, $userid)) ) {                $this->error('登录过期或账号在别处登录','401');            }        }        //线下方式        if( HUANG_JING == 0 ) {            $userId = Yii::$app->getSession()->get('userId');            if( $userId ) {                $factory->getuser($userId)->getIdentity();            } else {                 $this->error('请登入后再操作!',401);            }        }        //不需要验证权限的方法        $noCheckMethod = $this->noCheckMethod();        if( in_array( $method, $noCheckMethod ) ) {            return true;        }        //最后检查是否有权限        if( $factory->getmember()->checkPower( $method ) ) {            return true;        }        $this->error('没有权限','403');    }    //生成签名    public function createSign($array)    {        $md5_sign_string = '';        foreach($array as $key => $value) {            if( is_array($value) ) {                foreach ($value as $key2 => $value2)                {                    $md5_sign_string .= $key.'['.$key2.']'.'='.$value2;                }            } else {                $md5_sign_string .= $key.'='.$value;            }        }        $md5_sign_string = strtoupper(md5($md5_sign_string.self::KEY));        return $md5_sign_string;    }    //把json_post 方式转换成 post数组    public function jsonToArray($json)    {        $array = json_decode($json);        if(!$array) {            return false;        }        $new_array = [];        foreach($array as $key => $value)        {            $key = $this->stringToArray($key);            if(is_array($key)) {                $new_array[$key['parent']][$key['sun']] = $value;            } else {                $new_array[$key] = $value;            }        }        return $new_array;    }    //把 post[key]=‘XX' 这样的转换成 post['key'=>'xx'] 这样的数组    public function stringToArray($string)    {        $string_array = explode('[',$string);        if(count($string_array)>1) {            return (['parent'=>$string_array[0],'sun'=>substr($string_array[1],0,-1)]);        }        return $string;    }    //不需要登入可操作的方法    public function noLoginMethod()    {        return [            'user/register',            'user/login',            'note/register',            'im/index',            'note/check-register',            'user/test',            'order/ali',            'user/uploadbase64',            'user/msgpassword',            'note/find',            'user/check-token',        ];    }    //不需要验证权限可操作的方法    public function noCheckMethod()    {        return [            'user/changepassword',            'user/getsign',            'member/list',            'user/updateinfo',            'user/getinfo',            'hotheadlines/list',            'hotheadlines/newslist',            'order/create',            'order/pay',            'user/logout',            'user/sign',            'member/wallet',            'member/withdraw-deposit',            'member/transfer-accounts',            'member/money2diamond',            'member/diamond2money',            'member/bill',            'user/setinvitecode',            'user/find',            'buddy/apply',            'buddy/agree',            'buddy/refuse',            'buddy/buddylist',            'buddy/delete',            'buddy/list',            'buddy/move',            'buddy/find',            'userverify/list',            'userverify/agree',            'userverify/delete',            'userverify/refuse',            'usernotice/list',            'usernotice/listios',            'team/create',            'team/find',            'team/apply',            'team/remove',            'team/add',            'team/kick',            'team/info',            'team/members',            'team/join-teams',            'team/my-teams',            'team/member',            'bookshelf/add',            'bookshelf/delete',            'bookshelf/list',            'channel/create',            'channel/list',            'channel/delete',            'vipvideo/getinfo',            'follow/add',            'follow/cencel',            'follow/myfollow',            'follow/myfans',            'follow/otherfans',            'follow/otherfollow',            'channel/send-gifts',            'ranking/hour',            'ranking/day',            'ranking/week',            'ranking/month',            'ranking/match',            'ranking/always',            'channel/begin',            'channel/finish',            'channel/into',        ];    }    /**     * @desc 发送成功的json数据     * @param type $data 数据     * @return type     */    public static function success($data='',$message = 'ok')    {        header('Content-type: application/json');        if( empty($data) ) {            $data = new stdClass();        }        echo json_encode(['code'=>200,'message'=>$message,'data'=>$data]);        /*// 记录结束时间        $time_end = getmicrotime();        $time = $time_end - $GLOBALS['time_start'];// 输出运行总时间        echo "执行时间 $time seconds";*/        die;    }    /**     * @desc 发送失败的json数据     * @param type $data 数据     * @return type     */    public static function error($model = '',$code = 400)    {        header('Content-type: application/json');        if( is_string($model) or is_null($model) ) {            $msg = $model;        } else {            $msg = self::modelMessage($model->errors);        }        $data = new stdClass();        echo json_encode(['code'=>$code,'message'=>$msg,'data'=>$data]);        die;    }    //返回model中的错误信息    public static function modelMessage($array)    {        if (count($array) <= 0)        {            return '';        }        $msg = '';        foreach ($array as $val)        {            $msg .= isset($val[0]) ? $val[0] : $val;        }        return $msg;    }    protected function baseAction($form, $method)    {        $model = new $form;        $model->setScenario($method);        if ($model->load(Yii::$app->request->post())) {            $model->user_id = Yii::$app->factory->getuser()->userId;            $result = $model->$method();            if( $result ) {                if($result !== true) {                    $this->success( $result );                } else {                    $this->success();                }            } else {                $this->error( $model );            }        } else {            $this->error('数据加载错误!');        }    }}