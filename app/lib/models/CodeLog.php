<?php

namespace lib\models;

use Yii;

/**
 * This is the model class for table "er_code_log".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $create_time
 */
class CodeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_code_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['create_time'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'create_time' => 'Create Time',
        ];
    }

    public static function addlog($title,$data)
    {
        ob_start();
        var_dump($data);
        $content = ob_get_contents();
        ob_end_clean();
        $model = new CodeLog();
        $model->title = $title;
        $model->content = $content;
        $model->create_time = date('Y-m-d H:i:s',time());
        $model->save();
    }
}
