<?php

namespace lib\models;
use lib\forms\UploadForm;
use Yii;
use lib\traits\operateDbTrait;
/**
 * This is the model class for table "at_channel".
 *
 * @property integer $iid
 * @property integer $user_id
 * @property string $name
 * @property integer $type
 * @property string $cid
 * @property integer $ctime
 * @property string $pushUrl
 * @property string $httpPullUrl
 * @property string $hlsPullUrl
 * @property string $rtmpPullUrl
 * @property integer $status
 */
class Channel extends \yii\db\ActiveRecord
{
    use operateDbTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_channel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'status', 'look_number', 'roomid'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['cid'], 'string', 'max' => 32],
            ['ctime', 'safe'],
            [['pushUrl', 'httpPullUrl', 'hlsPullUrl', 'rtmpPullUrl', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'user_id' => 'User ID',
            'name' => 'Name',
            'type' => 'Type',
            'cid' => 'Cid',
            'ctime' => 'Ctime',
            'pushUrl' => 'Push Url',
            'httpPullUrl' => 'Http Pull Url',
            'hlsPullUrl' => 'Hls Pull Url',
            'rtmpPullUrl' => 'Rtmp Pull Url',
            'status' => 'Status',
        ];
    }

    public function getUserinfo()
    {
        return $this->hasOne(User::className(), ['iid'=>'user_id'])->select('iid,nickname,head,vip_type,fans_number');
    }
    //更新直播封面
    public static  function updateimg($img){
        $local_path=UploadForm::savebase64tofile($img);
        if($local_path)
        {
            $img = new \yii\extend\Image($local_path,pathinfo($local_path, PATHINFO_EXTENSION));
            $img->noopsyche(500,500);   //裁剪图片
            $head_arr= fastdfs_storage_upload_by_filename($local_path); //保存到图片服务器
           if($head_arr&&is_array($head_arr)){
                if(empty($head_arr['group_name']) ||  empty($head_arr['filename'])) {
                    return $local_path;
                } else {
                    $server = Yii::$app->params['imgServer'][$head_arr['group_name']] ?? '';
                    @unlink($local_path);  //删除文件
                    return $server . $head_arr['group_name'] . '/' . $head_arr['filename'];
                }
            }else{
                 return    $local_path;
            }

        }
        return '';
    }
}
