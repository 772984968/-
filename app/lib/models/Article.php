<?php

namespace lib\models;

use Yii;
use lib\behavior\CommentBehavior;
/**
 * This is the model class for table "my_article".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property string $create_time
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    public function behaviors()
    {
        return [
            'CommentBehavior' => CommentBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'cat_id', 'article_type', 'status', 'create_time', 'is_hot', 'is_top', 'is_recommend', 'sort_order','collection','click','comment_number','praise_number','look_number','turn_number'], 'integer'],
            [['title', 'content'], 'required'],
            [['desc', 'content'], 'string'],
            [['title', 'keywords'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 30],
            [['author_email'], 'string', 'max' => 60],
            [['article_img'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'cat_id' => '该文章的分类',
            'title' => '标题',
            'desc' => '文章描述',
            'content' => '内容',
            'author' => '文章作者',
            'author_email' => '文章作者的email',
            'keywords' => '文章的关键字',
            'article_type' => '文章类型',
            'article_img' => '文章图片',
            'status' => '2不显示 1显示',
            'create_time' => '添加时间',
            'is_hot' => '是否热门 2不是 1 是',
            'is_top' => '是否头条 2不是 1 是',
            'is_recommend' => '是否推荐 2 不推荐 1 推荐',
            'collection' => '收藏次数',
            'sort_order' => '文章显示顺序',
            'click'  => '文章点击数',
            'comment_number'=>'评论数',
            'praise_number'=>'点赞数',
            'look_number'=>'查看数',
            'turn_number'=>'转发数'
        ];
    }


    /**
     * [getAccount join db_user_cate]
     * @return [type] [description]
     */
    public function getCate()
    {
        return $this->hasOne(Articlecat::className(), ['cat_id' => 'cat_id']);
    }
}
