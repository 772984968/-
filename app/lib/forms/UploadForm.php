<?php
namespace lib\forms;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
class UploadForm extends Model
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

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => ['mp4', 'mp3', 'jpg' ,'jpeg' ,'png'], 'checkExtensionByMimeType' => false],
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
        $this->save_path = empty($this->save_path) ? 'uploads' : $this->save_path;
        $this->local_path = dirname(Yii::$app->basePath) . DIRECTORY_SEPARATOR . $this->save_path . DIRECTORY_SEPARATOR;
        $this->web_path = Yii::$app->params['webpath'] . '/'.$this->save_path.'/';

        $this->file = UploadedFile::getInstance($this, $fieldname);

        if ($this->file && $this->validate()) {
            //文件名
            $filename = mt_rand(1100,9900) .time() .mt_rand(1100,9900).'.' . $this->file->extension;
            //本地保存的完整路径
            $local_path = $this->local_path . $filename;

            if( !is_dir($this->local_path) ) {
                mkdir($this->local_path,775,true);
                chmod($this->local_path, 0775);
            }
            if( $this->file->saveAs( $local_path ) ) {    //保存成功
                $this->local_paths = $local_path;
                $this->web_paths = ['url'=>$this->web_path . $filename];
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 保存
     */
    public static function savebase64($data)
    {


        $save_path = 'uploads';
        $local_path = dirname(Yii::$app->basePath) . DIRECTORY_SEPARATOR . $save_path . DIRECTORY_SEPARATOR;
        $web_path = Yii::$app->params['webpath'] . '/'.$save_path.'/';

        $base64_image_content = $data;

        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            if(!in_array($type,['jpg','png','jpeg'])) {
                return '';
            }

            $filename = mt_rand(1100,9900) .time() .mt_rand(1100,9900).'.' . $type;
            //本地保存的完整路径


            if( !is_dir($local_path) ) {
                mkdir($local_path);
            }
            $local_path = $local_path . $filename;
            $base64_image_content = base64_decode(str_replace($result[1], '', $base64_image_content));
           
            if (file_put_contents($local_path, $base64_image_content)) {
                $url = $web_path . $filename;
                return $url;
            } else {
                return '';
            }
        }

    }


    /**
     * 保存
     */
    public static function savebase64tofile($data)
    {


        $save_path = 'uploads';
        $local_path = dirname(Yii::$app->basePath) . DIRECTORY_SEPARATOR . $save_path . DIRECTORY_SEPARATOR;


        $base64_image_content = $data;

        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            if(!in_array($type,['jpg','png','jpeg'])) {
                return '';
            }

            $filename = mt_rand(1100,9900) .time() .mt_rand(1100,9900).'.' . $type;
            //本地保存的完整路径


            if( !is_dir($local_path) ) {
                mkdir($local_path);
            }
            $local_path = $local_path . $filename;
            $base64_image_content = base64_decode(str_replace($result[1], '', $base64_image_content));

            if (file_put_contents($local_path, $base64_image_content)) {
                return $local_path;
            } else {
                return '';
            }
        }

    }

    
}