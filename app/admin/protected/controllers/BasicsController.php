<?php 
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;

/**
* @description 管理员基类
* @date   2015-03-26
* @author [Alisa] <[]>
*/
class BasicsController extends Controller
{
    /**
     * [$data 数据输出数组]
     * @var [array]
     */
    public $data = [];

    /**
     * [$enableCsrfValidation 是否验证表单提交]
     * @var boolean
     */
    public $enableCsrfValidation = true;

    /**
     * [初始化]
     * @return null
     */
    public function init()
    {
        parent::init();
        if (!$this->get('isCsrf')) $this->enableCsrfValidation = false;

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
        return $this->render($view, $this->data);
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
     * 错误处理
     * @author kevin
     * @return type
     */
    private function _Error($exception = '')
    {
        exit('<!DOCTYPE html>
        <html>
        <head>
            <title></title>
        </head>
        <body>
        <p> ' . $exception . '</p>
                <p>
                    The above error occurred while the Web server was processing your request.
                </p>
                <p>
                    Please contact us if you think this is a server error. Thank you.
                </p>
        </body>
        </html>');
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
?>