<?php

namespace lib\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
class UploadImageForm extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;
    public $local_paths;        //保存好的图片，的本地地址
    public $web_paths;          //保存好的图片，的网络地址
    public $local_path;         //存放图片的完整路径
    public $web_path;           //网站地址完整路径
    public $save_path;          //存放图片的现对路径

    public function init()
    {
        parent::init();
        $this->save_path = empty($this->save_path) ? 'uploads' : $this->save_path;
        $this->local_path = dirname(Yii::$app->basePath) . DIRECTORY_SEPARATOR . $this->save_path . DIRECTORY_SEPARATOR;
        $this->web_path = Yii::$app->params['webpath'] . '/'.$this->save_path.'/';

    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => ['jpg', 'png', 'jpeg'], 'checkExtensionByMimeType' => false],
        ];
    }

    public function attributeLabels(){
        return [
            'file'=>'文件上传'
        ];
    }

    /**
     * 保存
     */
    public function save($fieldname)
    {
        $this->file = UploadedFile::getInstance($this, $fieldname);

        if ($this->file && $this->validate()) {
            //文件名
            $filename = mt_rand(1100,9900) .time() .mt_rand(1100,9900).'.' . $this->file->extension;
            //本地保存的完整路径
            $local_path = $this->local_path . $filename;
            if( !is_dir($this->local_path) ) {
                mkdir($this->local_path,0775,true);
                //chmod($this->local_path, 0775);
            }
            if( $this->file->saveAs( $local_path ) ) {    //保存成功
                $this->local_paths = $local_path;
                $this->web_paths = ['url'=>$this->web_path . $filename];
                //$this->web_paths = $this->web_path . $filename;
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
        if(is_file($this->local_path)) {
            unlink($this->local_path);
        }
    }
}