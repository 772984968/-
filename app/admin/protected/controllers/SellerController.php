<?php 
namespace app\controllers;

use app\controllers\BasicsController;
use yii\data\Pagination;
use yii;

/**
* @description 基类
* @date   2015-03-31
* @author gqa
*/
class SellerController extends BasicsController
{
    /**
     * [$admin 用户个人信息]
     * @var [type]
     */
    public $admin;

    /**
     * [init 初始化]
     * @return [type] [description]
     */
    public function init()
    {
        parent::init();  

        if (empty(\Yii::$app->session['admin'])) 
        {
            $this->redirect(\Yii::$app->params['url']['login']);
        }
        else
        {

            # 管理员信息
            $this->admin = \yii::$app->session['admin'];

            $this->data['admin'] = $this->admin;
            # 权限
            $this->_setPower();
            \yii::$app->params['setting'] = \lib\models\Setting::getSetting();
            
        }   
    }

    /**
     * [page 分页]
     * @param  [int] $count [总条数]
     * @return [type]        [description]
     */
    public function page($count)
    {

        $pagination = new Pagination([
            'pageSize'   => \yii::$app->params['pageSize'],
            'totalCount' => $count,
        ]);
        
        return $pagination;
    }

    /**
     * [query 查询所有记录]
     * @param  [type] $model [Model]
     * @param  string $with  [联表]
     * @param  array $where [条件]
     * @param  string $order [排序]
     * @return [type]        [description]
     */
    public function query($model, $with = '', $where = [], $order = 'id desc')
    {
        $query = $model->find();
        //if ($with != '') $query = $query->innerJoinWith($with);
        if ($where != '') $query  =  $query->where($where);
        if ($with != '') $query = $query->JoinWith($with);


        $count = $query->count();
        $page  = $this->page($count);

        $query  = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();
        
        return ['count' => $count, 'page' => $page, 'data' => $query];
    }

    public function query2($model, $with = '', $where = [], $order = 'id desc')
    {
       
        $query = $model->find();
        //if ($with != '') $query = $query->innerJoinWith($with);
        if ($with != '') $query = $query->With($with);
        if ($where != '') $query  =  $query->where($where);

        $count = $query->count();
        $page  = $this->page($count);

        $query  = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->asArray()->all();

        return ['count' => $count, 'page' => $page, 'data' => $query];
    }

    /**
     * [beforeAction description]
     * @param  [type] $action [description]
     * @return [type]         [description]
     */
    public function beforeAction($action)
    {
        $url = '/' . $this->id . '/' . $this->action->id;
        $key = array_search($url, \yii::$app->params['url']);

        /*if (!in_array($key, $this->data['power'])) 
        {
            $this->error(\yii::t('app', 'powerError'));
        }*/

        # 操作日志
        if($this->isPost())
        {
            $this->_doLog();
        }

       return parent::beforeAction($action);
    }


    /**
     * [_setPower 传递角色权限到视图]
     */
    private function _setPower()
    {
        $power = $this->admin['isAdmin'] != 1 ? \yii::$app->session['power'] : '';
        $power = \app\library\MenuLibrary::app()->getPower($power);   
        $this->data['power'] = $power;
    }

    /**
     * [_doLog 操作日志]
     * @return [type] [description]
     */
    private function _doLog()
    {
        $model = new \lib\models\AdminDolog;
        $power = new \lib\models\Power;

        # 操作名称
        $url   = '/' . $this->id . '/' . $this->action->id;
        $key   = array_search($url, \yii::$app->params['url']);
        $query = $power->findOne(['url' => $key]);
        $title = isset($query['name']) ? $query['name'] : '';

        # 操作内容
        if(isset($_POST['id']) && trim($_POST['id']) != '')
        {
            $title .= ',id=' . $_POST['id'];
        }

        if(isset($_GET['id']) && trim($_GET['id']) != '')
        {
            $title .= ',id=' . $_GET['id'];
        }

        if(isset($_POST['data']) && trim($_POST['data']) != '')
        {
            $title .= ',id=' . $_POST['data'];
        }
        
        $doing  = json_encode($_POST);

        # 入库
        $data = array();
        $data['ip']       = \Yii::$app->request->getUserIp();
        $data['time']     = time();
        $data['uid']      = $this->admin['id'];
        $data['username'] = $this->admin['account'];
        $data['action']   = strtolower($this->action->id);
        $data['title']    = $title;
        $data['doing']    = $doing;
        
        $model->attributes = $data;
        $model->save();
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


    //导出EXCEL
	public function iputExcel($fileName,$tableName){
		include_once("../lib/vendor/phpexcel/PHPExcel/IOFactory.php");
		$PHPExcel_IOFactory = new \PHPExcel_IOFactory();
		$inputFileType = 'Excel5';    //这个是读 xls的
		//$fileName='http://image.kake.cc/file/20160216/9fa614290de.xls';
		$pathinfo = parse_url($fileName);
		$inputFileName = dirname(ROOT).'/upload/'.$pathinfo['path'];//$fileName;
		$objReader = $PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);
		$objWorksheet = $objPHPExcel->getActiveSheet();//取得总行数
		$highestRow = $objWorksheet->getHighestRow();//取得总列数
		$highestColumn = $objWorksheet->getHighestColumn();
		$highestColumnIndex = $objWorksheet->getColumnNums($highestColumn);//总列数
		$headtitle=array();
		$classColumn = '';
		$valuelist = array();
		for ($col = 0;$col < $highestColumnIndex;$col++)
		{
			if ($col>0)	$classColumn .=",";
			$classColumn .="`".$objWorksheet->getCellByColumnAndRow($col, 1)->getValue()."`";
		}
		for ($row = 2;$row <= $highestRow;$row++)
		{
			$strs='';
			//注意highestColumnIndex的列数索引从0开始
			for ($col = 0;$col < $highestColumnIndex;$col++)
			{
				if ($col>0)	$strs .=",";
				$strs .= "'".$objWorksheet->getCellByColumnAndRow($col, $row)->getValue()."'";
			}
			$valuelist[] = $strs;

		}
		/*这里写入库*/
		if (!empty($valuelist) && !empty($classColumn)){
			$sql = "INSERT INTO ".$tableName." (".$classColumn.") VALUES ";
			foreach ($valuelist as $key=> $val){
				if ($key>0){
					$sql .=",";
				}
				$sql .="(".$val.")";
			}
			$sql .=";";
			\yii::$app->db->createCommand($sql)->query();
		}
	}


    //定义图片尺寸
    function resizeImage($im,$maxwidth,$maxheight,$name,$filetype)
    {
        $pic_width = imagesx($im);
	    $pic_height = imagesy($im);
	    if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
	    {
	        if($maxwidth && $pic_width>$maxwidth)
	        {
	            $widthratio = $maxwidth/$pic_width;
	            $resizewidth_tag = true;
	        }

	    if($maxheight && $pic_height>$maxheight)
	    {
	        $heightratio = $maxheight/$pic_height;
	        $resizeheight_tag = true;
	    }

	    if($resizewidth_tag && $resizeheight_tag)
	    {
	        if($widthratio<$heightratio)
	            $ratio = $widthratio;
	        else
	            $ratio = $heightratio;
	    }

	    if($resizewidth_tag && !$resizeheight_tag)
	        $ratio = $widthratio;
	    if($resizeheight_tag && !$resizewidth_tag)
	        $ratio = $heightratio;

	    $newwidth = $pic_width * $ratio;
	    $newheight = $pic_height * $ratio;

	    if(function_exists("imagecopyresampled"))
	    {
	        $newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
	        imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
	    }
	    else
	    {
	        $newim = imagecreate($newwidth,$newheight);
	        imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
	    }

	    $name = $name.$filetype;
	    imagejpeg($newim,$name);
	    imagedestroy($newim);
	    }
	    else
	    {
	        $name = $name.$filetype;
	        imagejpeg($im,$name);
	    }
    }
}
