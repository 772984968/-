<?php
/**
 * Created by zendstudio.
 * User: Dev
 * Date: 2016/01/25 1612
 * Time: 上午 9:55
 */

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\data\Pagination;

class WebController extends Controller
{
    /**
     * 提交查询验证
     * @var boolean
     */
    public $enableCsrfValidation = false;
    public $isPost = false;
    public $_data;
	public $_setting = array();
	public $apiData = false;
	public $userData = [];
	public $uid = 0;
	public $discount = 1;
	public $proxy_code = '';
	public $_gen_path = '';
	public $gen_path = '';

	public function init()
    {
        parent::init();
// 		$this->proxy_code = \Yii::$app->request->get("c", "");
// 		$proxy_session = \Yii::$app->session->get('PROXYCODE', "");
// 		if (!empty($this->proxy_code) && $this->proxy_code != $proxy_session)
// 		{
// 			\Yii::$app->session->set('PROXYCODE', $this->proxy_code);
// 		}
		
		$redirect = \Yii::$app->request->get('redirect', null);
		$this->_data['redirect'] = $redirect === null ? Yii::$app->request->getReferrer() : urldecode($redirect);
		//设置文件
		$settingData = \lib\hooks\systemHook::app()->setting();
		\Yii::$app->params['setting'] = $this->_data['settingData'] = $this->_setting = $settingData['data'];
		//分类列表
		$res = \lib\models\Classify::find()->select(['cat_id','cat_name'])->where(['pid' => 0])->asArray()->all();
		$data = [];
		foreach($res as $key => $value){
			$data[$key]['cat_id'] = $value['cat_id'];
			$data[$key]['cat_name'] = $value['cat_name'];
			$data[$key]['son'] = \lib\models\Classify::find()->select(['cat_id','cat_name'])->where(['pid' => $value['cat_id']])->asArray()->all();
		}
		$this->_data['classifylist'] = $data;
		//获取买配件菜单
		$cate = new \lib\models\UserCate();
		$user_cate = $cate::find()->where(['pid' => [1, 2], 'is_show' => 1])->asArray()->all();
		$this->_data['user_cate'] = $user_cate;
        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            $this->isPost = true;
        }
		$this->gen_path = \Yii::$app->params['genPath'];
		$this->_gen_path = ROOT.\Yii::$app->params['uploadPath'];
		\Yii::$app->session->set('PID', \Yii::$app->request->get('pid', 0));
		$this->userData = \Yii::$app->session->get('LOGIN');
		$this->_data['uid'] = $this->uid = !empty($this->userData) ? $this->userData['id'] : 0;
		$link = \lib\models\FriendLink::find()->asArray()->all();
		$this->_data['link'] = $link;
		//用户注册类型id
		$this->_data['typeid'] = $cateid = !empty($this->userData) ? $this->userData['cateid'] : 0;
		$this->_data['userLogin'] = $this->userData;
		$this->_data['focus'] = 'index';
		$this->_data['cartData'] =$this->cartlist( $this->uid);
		$this->_data['t'] = \Yii::$app->request->get("t");
    }

    /**
     * 卡客权限判断
     * @param  [type] $cateid [用户类型id]
     * @return [type]         [description]
     */
    public  function power($cateid)
    {
    	$goodspower = new \lib\models\GoodsPower();
    	$power = $goodspower->find()->where(['user_type' => $cateid])->all();
    	$access = [];
    	if($power)
    	{
    		foreach ($power as $k => $v)
    		{
    			switch ($v['power_type'])
    			{
    				//可以访问批发价
    				case 0:
    					$access['accessp'] = explode(',',$v['power']);
    					break;
    				//可以访问销售价
    				case 1:
    					$access['access'] = explode(',',$v['power']);
    					break;
    				//购买可按批发价购买
    				case 2:
    					$access['buyp'] = explode(',',$v['power']);
    					break;
    				//购买按销售价购买
    				case 3:
    					$access['buy'] = explode(',',$v['power']);
    					break;
    				//发布价格种类
    				case 4:
    					$access['push'] = explode(',',$v['power']);
    					break;
    				default:
    					# code...
    					break;
    			}
    		}
    	}
    	return $access;
    }

    /**
     * [page 分页]
     * @param  [int] $count [总条数]
     * @return [type]        [description]
     */
    public function page($count,$pageSize)
    {
    	return $pagination = new Pagination([
    			'pageSize'   => $pageSize,
    			'totalCount' => $count,
    			]);
    }
    
    /**
     * [query 查询所有记录]
     * @param  [type] $model [Model]
     * @param  string $with  [联表]
     * @param  array $where [条件]
     * @param  string $order [排序]
     * @return [type]        [description]
     */
    public function query($model, $with = '', $where = [], $order = 'id desc',$pageSize=10)
    {
    	$query = $model->find();
    	if ($with != '') $query = $query->innerJoinWith($with);
    	if ($where != '') $query  =  $query->where($where);
    
    	$count = $query->count();
    	$page  = $this->page($count,$pageSize);
    	$query  = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();
    
    	return ['count' => $count, 'page' => $page, 'data' => $query,'pageSize'=>$pageSize];
    }
    /**
     * [view 渲染视图]
     * @param  string $view [视图名称]
     * @return [type]       [nul]
     */
    public function view($view = '')
    {
    	if ($view == '')
    	{
    		$view = $this->action->id;
    	}
    	return $this->render($view, $this->_data);
    }
	protected function getThisUrl($action)
	{
		if (!empty($this->userData))
		{
			$_GET['c'] = $this->userData['proxy_code'];
		}
		return Yii::$app->request->getHostInfo().Url::toRoute(array_merge([$action], $_GET));
	}
	

		/**
	 * 获取API数据
	 * @param type $requestName API名称
	 * @param type $requestData 请求数据
	 * @return array
	 * @throws type
	 */
	protected function requestHook($requestName, $requestData)
	{
		$this->apiData = isset(Yii::$app->params['apiurl'][$requestName]) ? Yii::$app->params['apiurl'][$requestName] : false;
		if ($this->apiData === false)
        {
            throw Exception('获取数据失败，请检查', 404);
        }
		if ($this->apiData['make'] == 2 && $this->uid == 0)
		{
			if ($this->isPost)
			{
				return Yii::$app->json->encode(['status' => 2, 'message' => '您还未登录，请先登录']);
			}
			$this->redirect(\yii\helpers\Url::toRoute('u/login'));
		}
		$controller = $this->apiData['controller'];
        $method		= $this->apiData['method'];
        $className  = (string) strtolower($controller) . 'Hook';
		$fileName	= dirname(ROOT).DS.'lib'.DS.'hooks'.DS.$className.'.php';
        if (!file_exists($fileName))
        {
            throw new \yii\web\HttpException(503, '获取数据失败，请检查');
        }
		$class = "\lib\\hooks\\".$className;
		$classObj = new $class();
        $classObj->retData = array('status' => 1);
        $classObj->requestData = $requestData;
        $classObj->object = $this;
        $return = $classObj->$method();

		$returnData = $classObj->requestEnd($return);
		if ($this->isPost === false && $returnData['status'] != 1)
		{
			throw new \yii\web\HttpException(500, $returnData['message']);
		}
		if (isset($returnData['data']))
        {
            $returnData['data'] = (array) $returnData['data'];
        }
		return (array) $returnData;
	}
	
	/**
	 * 获取客户端IP地址
	 * @return array
	 */
	public function clientIp() {
		header("Content-type: text/html; charset=gb2312");
		$ip138 = \Yii::$app->curl->post('http://1111.ip138.com/ic.asp', '');
		preg_match("#<center[^>]*>(.*?)<\/center>#", $ip138, $ipinfo);
		preg_match("/(?:\[)(.*)(?:\])/i", $ipinfo[1], $ip);
		$getaddress = empty($ipinfo[1]) ? '' : $ipinfo[1];
		$getip = empty($ip[1]) ? '' : $ip[1];
		return ['address' => iconv('GBK//IGNORE', 'UTF-8', $getaddress), 'ip' => $getip];
	}
	/**
	 * [get 获取GET参数]
	 * @param  string $key [参数名称]
	 * @return [string]      [参数值]
	 */
	public function get($key = '')
	{
		$get  = \Yii::$app->request->get($key);
	
		if (is_array($get))
		{
			foreach ($get as $k => $v)
			{
				$get[$k] = trim($v);
			}
	
			return $get;
		}
		else
		{
			return trim($get);
		}
	
	}
	/**
	 * [post post参数获取]
	 * @param  string $key [表单Name]
	 * @return [type]      [表单值]
	 */
	public function post($key = '')
	{
		$post = \Yii::$app->request->post($key);
		if (is_array($post))
		{
			foreach ($post as $k => $v)
			{
				$post[$k] = trim($v);
			}
			return $post;
		}
		else
		{
			return trim($post);
		}
	
	}
	
	/**
	 * [isPost 是否Post方式提交]
	 * @return boolean [返回值]
	 */
	public function isPost()
	{
		return Yii::$app->request->getIsPost();
	}
	
	/**
	 * [isGet 是否GET方式提交]
	 * @return boolean [description]
	 */
	public function isGet()
	{
		return Yii::$app->request->getIsAjax();
	}
	/**
	 * [isAjax 是否Ajax提交]
	 * @return boolean [返回值]
	 */
	public function isAjax()
	{
		return Yii::$app->request->getIsAjax();
	}
	
	/**
	 * [error 错误提示]
	 * @param  [type] $msg [提示语]
	 * @param  [type] $url [跳转URL]
	 * @param  [type] $close [是否关闭弹出层]
	 * @return [type]      [description]
	 */
	public function error($msg, $url = null, $close = false)
	{
		if($this->isAjax()){
			$array = array(
					'info' => $msg,
					'status' => false,
					'url' => $url,
					'close' => $close,
			);
			$this->ajaxReturn($array);
		}else{
			$this->alert($msg, $url);
		}
	}
	
	/**
	 * [success 成功提示]
	 * @param  [type] $msg [提示语]
	 * @param  [type] $url [跳转UrL]
	 * @param  [type] $close [是否关闭弹出层]
	 * @return [type]      [description]
	 */
	public function success($msg, $url = null, $close = false)
	{
		if($this->isAjax()){
			$array = array(
					'info' => $msg,
					'status' => true,
					'url' => $url,
					'close' => $close,
			);
			$this->ajaxReturn($array);
		}else{
			$this->alert($msg, $url);
		}
	}
	
	/**
	 * AJAX返回
	 * @param string $message 提示内容
	 * @param bool $status 状态
	 * @param string $jumpUrl 跳转地址
	 * @return array
	 */
	public function ajaxReturn($data)
	{
		header('Content-type:text/json');
		echo json_encode($data);
		exit;
	}
	
	/**
	 * [alert description]
	 * @param  [type] $msg     [description]
	 * @param  [type] $url     [description]
	 * @param  string $charset [description]
	 * @return [type]          [description]
	 */
	public function alert($msg, $url = NULL, $charset='utf-8')
	{
		header("Content-type: text/html; charset={$charset}");
		$alert_msg="alert('$msg');";
		if( empty($url) ) {
			$go_url = 'history.go(-1);';
		}else{
			$go_url = "window.location.href = '{$url}'";
		}
		echo "<script>$alert_msg $go_url</script>";
		exit;
	}
	/**
	 * @desc 验证数据
	 * @access protected
	 * @param int $data 数据
	 * @param bool $type 判断类型 string|int|bool
	 * @return mixed
	 */
	protected function request_verify($data, $type = 'string',$datavalue)
	{
		
		if(!is_array($data))
		{
			$data = array($data);
		}
		switch($type)
		{
			case 'string':
				foreach($data as $val)
				{	
					if (!isset($datavalue[$val]) || !is_string($datavalue[$val]) || empty($datavalue[$val]))
					{
						return '';
					}
				}
				break;
			case 'int':
				foreach($data as $val)
				{
					if (!isset($datavalue[$val]) || !is_numeric($datavalue[$val]))
					{
						return 0;
					}
				}
				break;
			case 'bool':
				foreach($data as $val)
				{
					if (!isset($datavalue[$val]) || !is_bool($datavalue[$val]))
					{
						return false;
					}
				}
				break;
			case 'date':
				foreach($data as $val)
				{
					if (!isset($datavalue[$val]) || !\lib\components\AdCommon::isDate($datavalue[$val]))
					{
						return '';
					}
				}
				break;
		}
		return true;
	}
	protected function cartlist($uid=''){
		$cartlist = array();
		if (!empty($uid)){
			$cartlist = \lib\models\Cart::find()->where(['uid'=>$uid])->all();
		}
		return $cartlist;
	}


	//多图上传
	public function upload_more($file = '', $savepath = '',$randname = false)
	{
		include_once("../lib/upload/Upload.class.php");
		$upload = new \Think\Upload();
		$savepath_current = $this->_gen_path .DIRECTORY_SEPARATOR .$savepath.DIRECTORY_SEPARATOR;
		if(!is_dir($savepath_current))
		{
			mkdir($savepath_current,0777,true);
		}
		/*相对路径*/
		$savepath .= DIRECTORY_SEPARATOR.date("Ymd").DIRECTORY_SEPARATOR;
		/*绝对路径*/
		$path = $this->_gen_path .DIRECTORY_SEPARATOR .$savepath;
		if(!is_dir($path))
		{
			mkdir($path,0777,true);
		}
		//设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
		$upload -> set("path", $path);
		$upload -> set("maxsize", 3145728);
		$upload -> set("allowtype", array("gif", "png", "jpg","jpeg"));
		$upload -> set("israndname", $randname);
		//使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
		if($upload -> upload($file)) {
			//获取上传后文件名子
			$data = $upload->getFileName();
			$str = array();
			foreach($data as $key => $value){
				$str[] = DIRECTORY_SEPARATOR.$savepath.$value;//相对路径
				$current = $path.$value;//据对路径
				$s_route = $path .'/s_'.$value ;
				/*加载imageine类*/
				$imagine = new \lib\vendor\imagine\Gd\Imagine();
				/*生成小图一*/
				$size    = new \lib\vendor\imagine\Image\Box(300, 300);
				$mode    = \lib\vendor\imagine\Image\ImageInterface::THUMBNAIL_INSET;
				$imagine->open($current)->thumbnail($size, $mode)->save($s_route);
			}
			return $str;
		} else {
			//获取上传失败以后的错误提示
			return "";
		}
	}


	/*
    * 生成下载excel文件
    * $filename="业务员录入数据";
    * $headArr=array("用户名","密码");
    * $data array(array('username'=>1,'pwd'=>2),array(...)..);
    * $this->getExcel($filename,$headArr,$data);
     *  */
	/*************************
	 * 修改函数，增加生成纵向表格
	 * author: lijunwei
	 * $filename：导出的文件名，默认加上生成文件日期;
	 * $headArr：一维数组，表头;
	 * $data:二维数组，要导出的数据;
	 * $type:导出表格类型，默认为1纵向表格，2为横向表格
	 * $search:文件名是否需要添加导出日期，默认为1，当=1时添加，当=0时不添加
	 * $this->getExcel($filename,$headArr,$data);
	 *************************/
	public function getExcel($fileName, $headArr, $data,$type=1,$search=1)
	{
		//对数据进行检验
		if (empty($data) || !is_array($data)) {
			die("没有数据可以导出！");
		}
		//检查文件名
		if (empty($fileName)) {
			exit;
		}

//        $objPHPExcel = new \PHPExcel();
		include_once("../lib/vendor/phpexcel/PHPExcel.php");
		$objPHPExcel = new \PHPExcel();

		//Set properties 设置文件属性
		$objProps = $objPHPExcel->getProperties();

		//设置文件名
		if($search==1){
			$date = date("Y_m_d", time());
			$fileName .= "_{$date}.xls";
		}elseif($search==0){
			$fileName .= ".xls";
		}

		//导出数据的默认格式：第一行表头，下方为数据
		if ($type == 1) {
			//导入表头
			$key = ord("A");
			foreach ($headArr as $v) {
				$colum = chr($key);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
				//单元格宽度自适应
				$objPHPExcel->getActiveSheet()->getColumnDimension($colum)->setAutoSize(true);
				$key += 1;
			}
			//写入数据
			$column = 2;
			$objActSheet = $objPHPExcel->getActiveSheet();
			foreach ($data as $key => $rows) { //行写入
				$span = ord("A");
				foreach ($rows as $keyName => $value) { // 列写入
					$j = chr($span);
					//写入数据
					$objActSheet->setCellValue($j . $column, chunk_split($value, 500, ' '));
					//设置左右对齐
					$objActSheet->getStyle($j . $column)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$span++;
				}
				$column++;
			}
		}
		//导出数据的第二种格式：第一列表头，右边为数据
		elseif($type==2){
			//导入表头
			$key = 1;
			foreach ($headArr as $v) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, $v);
				$key += 1;
			}
			//写入数据
			$span = ord("B");
			$objActSheet = $objPHPExcel->getActiveSheet();
			foreach ($data as $key => $rows) {//列写入
				$column = 1;
				foreach ($rows as $keyName => $value) {//行写入
					$j = chr($span);
					//写入数据
					$objActSheet->setCellValue($j . $column, chunk_split($value, 500, ''));
					//设置左右对齐
					$objActSheet->getStyle($j . $column)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					//单元格宽度自适应
					$objActSheet->getColumnDimension($j)->setAutoSize(true);
					$column++;
				}
				$span++;
			}
		}
		$fileName = iconv("utf-8", "gb2312", $fileName);
		//重命名工作表标签
		//$objPHPExcel->getActiveSheet()->setTitle($date);
		//设置活动单指数到第一个表,所以Excel打开这是第一个表
		$objPHPExcel->setActiveSheetIndex(0);
		ob_end_clean(); //清除缓冲区,避免乱码,那些年被坑过的乱码
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;filename=\"$fileName\"");
		header('Cache-Control: max-age=0');

		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); //文件通过浏览器下载
		exit;
	}
	/**
	 * 添加系统消息
	 * @param string $uid
	 * @param string $title
	 * @param string $content
	 * @param unknown $type
	 * @return Ambigous <\lib\hooks\type, multitype:number >|boolean
	 */
	public function addmessage($uid='',$title ='' , $content=''){
		$sysmessModel = new \lib\models\Sysmessage();
		$sysmessModel->attributes = [
		'm_uid' => $uid,
		'title' => $title,
		'content' => $content,
		'addtime' => time(),
		'status' => 0,
		];
		if (!$sysmessModel->validate())
		{
			return self::returnMerge(-3, \lib\components\AdCommon::modelMessage($sysmessModel->errors));
		}
		$sysmessModel->save();
		return true;
	}


	public function upload_image($savepath = ''){
		// Make sure file is not cached (as it happens for example on iOS devices)
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			exit; // finish preflight CORS requests here
		}

		if ( !empty($_REQUEST[ 'debug' ]) ) {
			$random = rand(0, intval($_REQUEST[ 'debug' ]) );
			if ( $random === 0 ) {
				header("HTTP/1.0 500 Internal Server Error");
				exit;
			}
		}

		@set_time_limit(5 * 60);

		$targetDir = 'upload_tmp';
//		$path = 'upload';
		$path = date("Ymd");
		/*相对路径*/
		$uploadDir = $savepath .DIRECTORY_SEPARATOR .$path;
		if(!is_dir($uploadDir))
		{
			mkdir($uploadDir,0777,true);
		}

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

// Create target dir
		if (!file_exists($uploadDir)) {
			@mkdir($uploadDir);
		}

// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


// Remove old temp files
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}


// Open temp file
		if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

		$index = 0;
		$done = true;
		for( $index = 0; $index < $chunks; $index++ ) {
			if ( !file_exists("{$filePath}_{$index}.part") ) {
				$done = false;
				break;
			}
		}
		if ( $done ) {
			if (!$out = @fopen($uploadPath, "wb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}

			if ( flock($out, LOCK_EX) ) {
				for( $index = 0; $index < $chunks; $index++ ) {
					if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
						break;
					}

					while ($buff = fread($in, 4096)) {
						fwrite($out, $buff);
					}

					@fclose($in);
					@unlink("{$filePath}_{$index}.part");
				}

				flock($out, LOCK_UN);
			}
			@fclose($out);
		}

// Return Success JSON-RPC response die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}')
		echo $uploadDir;
	}
}
