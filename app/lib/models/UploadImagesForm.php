<?php

namespace lib\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use lib\nodes\User;
use yii\extend\FileUpload;
class UploadImagesForm extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;
    public $local_paths = [];   //保存好的图片，的本地地址
    public $web_paths = [];     //保存好的图片，的网络地址
    public $local_path;          //存放图片的路径
    public $web_path;           //网站地址路径
    public $save_path;          //存放图片的现对路径
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'maxFiles' => 9,'extensions'=>['jpg','png','jpeg'],/*'mimeTypes' => 'image/jpeg, image/png'*/'checkExtensionByMimeType' => false],
        ];
    }

    public function attributeLabels(){
        return [
            'file'=>'多文件上传'
        ];
    }

    /**
     * 保存
     */
    public function save($fieldname)
    {
        
        $this->file = UploadedFile::getInstances($this, $fieldname);

        if($this->file &&  $this->validate() )
        {
            $this->save_path = empty($this->save_path) ? '' : $this->save_path;
            if(empty($this->save_path)) {
                //默认地址
                $this->web_path = Yii::$app->params['webpath'] . '/uploads/';
                $this->local_path = dirname(Yii::$app->basePath) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
            } else {
                //设置后的地址
                $this->local_path = dirname(Yii::$app->basePath) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR .  str_replace("/",DIRECTORY_SEPARATOR,$this->save_path) . DIRECTORY_SEPARATOR;
                $this->web_path = Yii::$app->params['webpath'] . '/uploads/'. $this->save_path . '/';
            }

            foreach ($this->file as $fl) {
                //文件名
                $filename = mt_rand(1100,9900) .time() .mt_rand(1100,9900).'.' . $fl->extension;
                //本地保存的完整路径
                $local_path = $this->local_path . $filename;
                if( !is_dir($this->local_path) ) {
                    mkdir($this->local_path, 0775,true);
                    //chmod($this->local_path, 0775);
                }
                if( $fl->saveAs( $local_path ) ) {    //保存成功
                    $img = new \yii\extend\Image($local_path,'side');
                    $thunb_path = $img->noopsyche()->_tmpImg;//自定义裁切
                    $this->local_paths[] = $local_path;
                    $this->local_paths[] = $thunb_path;
                    $this->web_paths[] = ['source'=>$this->web_path . $filename,'thumb'=>$this->web_path . $img->tumb_name];
                }
            }
            return true;
        } else {
            return false;
        }

    }

    /**
     * 撤销保存，把保存的图片删除
     */
    public function cancel()
    {
        foreach($this->local_paths as $local_path) {
            unlink($local_path);
        }
    }
}