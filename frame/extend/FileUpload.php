<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace yii\extend;

class FileUpload {
    public $local_path;
    public $web_path;
    public $error;
    public $maxsize;
    public $path;
    public function upload($name)
    {
        $files = [];
        //1.获取要上传文件的信息
        $up_info=$_FILES[$name];

        $ob_path=$this->local_path;
        if( !is_dir($this->local_path) ) {
            mkdir($this->local_path,0777,true);
        }
        $typelist=array("jpg","jpeg","png","mp4","mpeg","mov","wmv"); //定义运行的上传文件类型
            //3.判断文件上传的类型是否合法
        $info = pathinfo($up_info['name']);
        if(!in_array(strtolower($info['extension']),$typelist)){
            //continue('文件类型错误！'.$up_info['type'][$i]);
            $this->error = '文件类型不允许';
            return false;
        }

            //4.上传文件的大小过滤

            if($up_info['size']>$this->maxsize){
                //continue('文件大小超过1000000');
                $this->error = '文件超过最大限制';
                return false;
            }


            //5.上传文件名处理

            $exten_name=pathinfo($up_info['name'],PATHINFO_EXTENSION);

            do{
                $main_name=date('YmHis'.'--'.rand(1000,9999));
                $new_name=$main_name.'.'.$exten_name;
            }while(file_exists($ob_path.DIRECTORY_SEPARATOR.$new_name));



            //6.判断是否是上传的文件，并执行上传

            if(is_uploaded_file($up_info['tmp_name'])){

                if(move_uploaded_file($up_info['tmp_name'],$ob_path.DIRECTORY_SEPARATOR.$new_name)){
                    //echo '文件上传成功！';
                    $files[] = ['thumb'=>$this->web_path.$new_name,'source'=>$this->web_path.$new_name];
                }else{
                    //echo '上传文件移动失败!';
                }
            }else{
                //echo '文件不是上传的文件';
            }
        return $new_name;
    }



}

?>
