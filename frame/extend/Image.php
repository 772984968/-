<?php
namespace yii\extend;
/**
 * Image Class
 * Driver: GD Library
 * 暂时未处理当缩略图比原图片小时 无法添加水印的情况。
 */
class Image {

    public  $_sourceImg ; // 源图片
    public  $_tmpImg;     // 操作图片
    public  $_imgType ;   // 图片后缀
    public  $_create;     // 执行方法
    public  $_save;       // 保存方法
    public  $_img4;       //图片资料
    public  $width=450;         //生成的图片宽度
    public  $height=450;        //生成的图片高度
    public  $tumb_name;         //缩略图名称

    public function __construct($image,$ext='thumb_') {

        if(is_file($image)){
            @chmod($image, 0777);
            $this->_sourceImg = $image;
            $this->_imgType   = pathinfo($image, PATHINFO_EXTENSION);
            $thumb_name = $ext.basename($image);
            $this->_tmpImg = dirname($image).'/'.$thumb_name;
            $this->tumb_name = $thumb_name;
            @copy($this->_sourceImg, $this->_tmpImg);
            @chmod($this->_tmpImg,0777);
            switch($this->_imgType){
                case 'gif' :
                    $this->_save = "imagegif";
                    $this->_create   = 'imagecreatefromgif';
                    break;
                case 'png' :
                    $this->_save = "imagepng";
                    $this->_create   = 'imagecreatefrompng';
                    break;
                case 'jpg' :
                case 'jpeg' :
                    $this->_save = "imagejpeg";
                    $this->_create   = 'imagecreatefromjpeg';
                    break;
                default :
                    return false;//throw new Exception("ERROR; UNSUPPORTED IMAGE TYPE");
                    break;
            }
        }else{
            //throw new Exception($image.' is not a Image-Source!');
        }
    }

    /*
    * 缩略图片
    * @param width Integer   图片剪裁后宽度
    * @param width Integer   图片剪裁后高度
    * @param auto  bool      是否等比例额剪裁
    * @param xoffset Integer 剪裁左端偏移量
    * @param yoffset Integer 剪裁顶端偏移量
    ***/
    function resize($width, $height, $auto = true, $xoffset = 0, $yoffset = 0){
        if($width > $height){
            $size = $width;
        }else{
            $size = $height;
        }
        $_create = $this->_create;
        $_save   = $this->_save;
        $img = $_create($this->_sourceImg);
        if($auto == TRUE){
            list($org_width, $org_height) = getimagesize($this->_sourceImg);
            if($org_width < $size && $org_height < $size){
                $img4= $img;
            }else{
                if($org_width > $org_height){
                    $swidth  = $size;
                    $sheight = ($org_height/$org_width) * $size;
                    $img4=imagecreatetruecolor ($swidth, $sheight);
                    imagecopyresampled($img4, $img, 0, 0, 0, 0, $swidth, $sheight, $org_width, $org_height);
                }else{
                    $swidth  = ($org_width/$org_height) * $size;
                    $sheight = $size;
                    $img4=imagecreatetruecolor ($swidth, $sheight);
                    imagecopyresampled($img4, $img, 0, 0, 0, 0, $swidth, $sheight, $org_width, $org_height);
                }
            }
            $value = $this->_imgType == 'png' ? 9 : 100;
            $_save($img4,$this->_tmpImg,$value);
            $img = $_create($this->_tmpImg);
        }else{
            // 自定义裁切
            $img_n=imagecreatetruecolor($width, $height);
            imagecopyresized($img_n, $img, 0, 0, $xoffset, $yoffset, $width, $height, $width, $height);
            $value = $this->_imgType == 'png' ? 7 : 75; // PNG图片质量最高为9 其他格式为 100 默认为75
            $_save($img_n,$this->_tmpImg,$value);
        }
        return $this;
    }

    /*
    * 返回处理后的图片地址
    * @param old bool 是否替换原图
    * return String
    **/
    public function save($old = false) {
        return $this->tumb_name;
    }

    public function noopsyche()
    {
        list($org_width, $org_height) = getimagesize($this->_sourceImg);

        if( $org_height >= $this->height && $org_width >= $this->width) {
            //宽高都比设置的小
            $height_bl = $org_height / $this->height;
            $width_bl = $org_width / $this->width;
            if($width_bl >= $height_bl) {
                //宽一些
                $xoffset = ($org_width-($this->width*$height_bl))/2;
                $org_width = $this->width*$height_bl; //设置取源图数据的宽度
            } else {
                //高一些
                $yoffset = ( $org_height - ( $this->height * $width_bl ) )/2;
                $org_height = $this->height * $width_bl; //设置取源图数据的宽度
            }
        } else if($org_width >= $this->width ) {
            //图片宽度比设置的大
            $height_bl = $this->height / $org_height;
            $xoffset = ($org_width- $this->width / $height_bl)/2;
            $org_width = $this->width / $height_bl; //设置取源图数据的宽度

        } else if($org_height >= $this->height ) {
            //图片高度比设置的大
            $width_bl = $this->width / $org_width;
            $yoffset = ($org_height- $this->height / $width_bl)/2;
            $org_height = $this->height / $width_bl; //设置取源图数据的宽度
        } else {
            //宽高都比设置的小
            $height_bl = $this->height / $org_height;
            $width_bl = $this->width / $org_width;

            if($width_bl <= $height_bl) {
                //宽一些
                $xoffset = ($org_width - $this->width / $height_bl)/2;
                $org_width = $this->width / $height_bl; //设置取源图数据的宽度

            } else {
                //高一些
                $yoffset = ($org_height - $this->height / $width_bl)/2;
                $org_height = $this->height / $width_bl; //设置取源图数据的宽度
            }
        }
        $yoffset = empty($yoffset) ? 0 : $yoffset;
        $xoffset = empty($xoffset) ? 0 : $xoffset;

        // 裁切
        $_save   = $this->_save;
        $_create = $this->_create;
        $img = $_create($this->_sourceImg);
        $img_n=imagecreatetruecolor($this->width, $this->height);
        imagecopyresized($img_n, $img, 0, 0, $xoffset, $yoffset, $this->width, $this->height, $org_width, $org_height);
        $value = $this->_imgType == 'png' ? 7 : 75; // PNG图片质量最高为9 其他格式为 100 默认为75
        $_save($img_n,$this->_tmpImg,$value);
        return $this;
    }

}
