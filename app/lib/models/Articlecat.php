<?php

namespace lib\models;

use Yii;

class Articlecat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_cat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'is_show', 'addtime', 'sort_order'], 'integer'],
            [['cat_name', 'parent_id', 'sort_order'], 'required'],
            [['cat_name'], 'string', 'max' => 15],
            // [['url'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', '父级ID'),
            'cat_name' => Yii::t('app', '分类名称'),
            'is_show' => Yii::t('app', '是否显示.0不显示.1显示'),
            'addtime' => Yii::t('app', '添加时间'),
            'sort_order' => Yii::t('app', '分类排序'),
            'keywords' => Yii::t('app', '关键字'),
            'cat_desc' => Yii::t('app', '分类描述'),
        ];
    }



}
