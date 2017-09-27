<?php

namespace lib\upload;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * 文件上传插件
 */
class Uploader extends Component
{

	public $_setting = array();				//系统配置信息
	public $_errors = null;					//错误信息
	public $_tmp_name = '';					//临时文件
	public $_real_name = '';				//原始文件名
	public $_file_name = '';				//生成的文件完整路径
	public $_thumb_name = '';               //生成缩略图的完整路径
	public $_file_ext = '';					//文件扩展名
	public $_file_size = '';				//文件大小
	public $_mime_type = '';				//MIME类型
	public $_is_image = false;				//是不是图片
	public $_rand_name = true;				//是否生成随机文件名
	public $_thumb_prefix = 'small_';		//缩略图前缀
	public $_images_path = 'upload/images/';  //默认图片上传路径
	public $_file_path = 'upload/files/';   //默认文件上传路径
	public $_register_path = 'upload/register/';   //默认头像上传路径
	public $_comment_path = 'upload/userauth/';   //默认用户认证上传路径
	public $_service_path = 'upload/usershop/';   //默认开店申请上传路径
	public $_head_path = 'upload/head/';   //默认头像上传路径
	public $_active_path = 'upload/active/';   //默认活动上传路径
	public $_user_path = 'upload/user/';   //默认个人图片上传路径

	/**
	 * 初始化
	 */
	public function init()
	{
		
		$this->_setting = Yii::$app->params['setting'];
		if (empty($this->_setting))
		{
			$this->_errors = '请先配置文件上传设置';
			return false;
		}
		return true;
	}

	public function uploadFile($data, $type='_images_path')
	{

 		$file = $_FILES[$data];
 		if (!$this->checkUpload($file))
 		{
 			//$this->_errors = '上传文件格式错误';
 			$redata=array('status'=>0,'message'=>$this->_errors);
 			return $redata;
 			
 		}
 		$pinfo=pathinfo($file["name"]);
 		$this->_file_ext = $pinfo['extension'];
		$show_path 	= $this->$type;
		$show_path .= date('Ymd', time()) . '/';
		$save_path = dirname(ROOT).DS.$show_path;
		$filename = $this->_rand_name ? substr(md5(uniqid('file')), 0,11).'.'.$this->_file_ext : $this->_real_name;
		$file_name=$file["tmp_name"];
		if(!is_dir($save_path))
		{
			mkdir($save_path, 0777, true);
		}
		$save_path .= $filename;
		
		$this->_file_name = $this->_setting['upload_domain'].(trim($show_path, 'upload')).$filename;
		if(!move_uploaded_file ($file_name, $save_path))
		{
			$redata=array('status'=>0,'message'=>'上传失败');
			return $redata;
		}else{
			$redata=array('status'=>1,'message'=>'上传成功','image'=>$this->_file_name);
			return $redata;
		} 
	}	
	/**
	 * 校验上传文件是否符合要求(包括文件类型、大小)
	 */
	public function checkUpload($file)
	{
		if (!$file || $file['error'] != UPLOAD_ERR_OK)
		{
			$this->_errors = '文件上传失败（'.($file).'）';
			//$this->_errors = '文件上传失败（'.$file['error'].'）';
			return false;
		}
		$this->_tmp_name = $file['tmp_name'];
		$this->_real_name = $file['name'];
		$this->_file_ext = $this->getExt($file['name']);
		$this->_mime_type = $file['type'];
		$this->_file_size = $file['size'];
		if(!in_array($this->_file_ext, explode(',', $this->_setting['image_ext'])))
		{
			$this->_errors = "禁止上传{$this->_file_ext}后缀的文件";
			return false;
		}

		if ($file['size'] > $this->_setting['image_size'] * 1024)
		{
			$this->_errors = "上传文件大小超出限制";
			return false;
		}

		if(!is_uploaded_file($this->_tmp_name))
		{
			$this->_errors = "系统临时文件错误";
			return false;
		}

		return true;
	}

	/**
	 * 取得上传文件的后缀
	 * @access private
	 * @param string $realname 文件名
	 * @return boolean
	 */
	private function getExt($realname)
	{
		$pathinfo = pathinfo($realname);
		return strtolower($pathinfo['extension']);
	}
	
}