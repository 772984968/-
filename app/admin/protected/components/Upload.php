<?php
namespace app\components;
/**
 * 文件上传插件
 */
class Upload
{

    public $_setting = array();             //系统配置信息
    public $_errors = null;                 //错误信息
    public $_tmp_name = '';                 //临时文件
    public $_real_name = '';                //原始文件名
    public $_file_name = '';                //生成的文件完整路径
    public $_thumb_name = '';               //生成缩略图的完整路径
    public $_image_ext = '';                 //图片扩展名
    public $_image_size = '';                //图片大小
    public $_file_ext = '';                 //文件扩展名
    public $_mime_type = '';                //MIME类型
    public $_is_image = false;              //是不是图片
    public $_rand_name = true;              //是否生成随机文件名
    public $_s_thumb_prefix = '';    //缩略图前缀
    public $_l_thumb_prefix = '';    //大图图前缀
    public $_image_path   = '';    //默认图片上传路径
    public $_thumb_path   = '';    //默认缩略图上传路径
    public $_file_path    = '';    //默认文件上传路径

    /**
     * [__construct 构造函数]
     */
    public function __construct()
    {
        $this->_setting = \lib\models\Setting::getSetting();

        if (empty($this->_setting))
        {
            $this->_errors = '请先配置文件上传设置';
            return false;
        }
        $this->_file_ext  = explode(',', $this->_setting['file_ext']);
        $this->_image_ext  = explode(',', $this->_setting['image_ext']);
        $this->_image_size = $this->_setting['image_size'];
        $this->_s_thumb_prefix = 's'; 								//缩略图前缀
        $this->_l_thumb_prefix = 'l'; 								//大图前缀
        $this->_image_path   = \yii::$app->params['imagePath'];    //默认图片上传路径
        $this->_thumb_path   = \yii::$app->params['thumbPath'];    //默认缩略图上传路径
        $this->_file_path    = \yii::$app->params['filePath'];     //默认文件上传路径
        return true;
    }

    /**
     * [uploadFile 上传图片]
     * @param  [type]  $file        [description]
     * @param  boolean $small_thumb [description]
     * @return [type]               [description]
     */
    public function uploadImage($file, $small_thumb = false,$type=1)
    {
        if(!empty($this->_errors)) return false;
        
        if (!$this->checkUpload($file,$type))
        {
            return false;
        }
        $tmp_name   = $file['tmp_name'];
        $show_path  = ($this->_is_image === true) ? $this->_image_path : $this->_file_path;
        $show_path .= date('Ymd', time()) . '/';
        $save_path  = ROOT.\yii::$app->params['uploadPath'].$show_path;
        
        $filename   = $this->_rand_name ? substr(md5(uniqid('file')), 0,11).'.'.$this->getExt($file['name']) : $file['name'];
        if(!is_dir($save_path))
        {
            mkdir($save_path, 0777, true);
        }
        
        $save_path       .= $filename;
        
        $this->_file_name = $this->_setting['upload_domain'].$show_path.$filename;
        
        $mv = move_uploaded_file($tmp_name, $save_path);

        if(!$mv)
        {
            $this->_errors = '移动文件失败';
            return false;
        }

        return true;
    }

    /**
     * 校验上传文件是否符合要求(包括文件类型、大小)
     */
    public function checkUpload($file,$type)
    {
        if (!$file || $file['error'] != UPLOAD_ERR_OK)
        {
            $this->_errors = '文件上传失败（'.$file['error'].'）';
            return false;
        }
        
        $file_ext = $this->getExt($file['name']);
        if ($type == '1'){
        	
	        if(in_array($file_ext, $this->_image_ext))
	        {
	            $this->_is_image = true;
	        }
	        if(!in_array($file_ext, $this->_image_ext))
	        {
	            $this->_errors = "禁止上传{$file_ext}后缀的文件";
	            return false;
	        }
	
	        if ($file['size'] > $this->_image_size * 1024)
	        {
	            $this->_errors = "上传图片大小超出限制";
	            return false;
	        }
        }else {
        	if(in_array($file_ext, $this->_file_ext))
        	{
        		$this->_is_image = false;
        	}
        	
        	if(!in_array($file_ext, $this->_file_ext))
        	{
        		$this->_errors = "禁止上传{$file_ext}后缀的文件";
        		return false;
        	}
        }
        if(!is_uploaded_file($file['tmp_name']))
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
        return trim(strtolower($pathinfo['extension']));
    }
}