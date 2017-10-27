<?php

namespace lib\models;

use Yii;
/**
 * This is the model class for table "video_list".
 *
 * @property integer $iid
 * @property string $user_id
 * @property string $vid
 * @property string $cid
 * @property string $orig_video_key
 * @property string $video_name
 * @property string $beginTime
 * @property integer $endtime
 */
class VideoList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_video_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iid'], 'integer'],
            ['text','string'],
         //   [['cid','orig_url'],'string'],
           // [['orig_video_key', 'video_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'IID',
            'user_id' => 'User Id',
            'vid' => 'Vid',
            'cid' => 'Cid',
            'orig_url' => 'Orig Url',
            'video_name' => 'Video Name',
            'orig_video_key' => 'Orig Video Key',
            'begin_time' => 'Begin Time',
            'end_time' => 'End Time',
        ];
    }
}
