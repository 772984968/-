<?php

namespace lib\models;
use lib\traits\operateDbTrait;
use Yii;

/**
 * This is the model class for table "at_book_shelf".
 *
 * @property integer $iid
 * @property string $book_id
 * @property integer $user_id
 * @property string $book_name
 * @property string $book_img
 * @property string $create_time
 */
class BookShelf extends \yii\db\ActiveRecord
{
    use operateDbTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'at_book_shelf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','book_id','book_name','book_img'],'required'],
            [['user_id'], 'integer'],
            [['book_id'], 'string', 'max' => 32],
            [['book_name'], 'string', 'max' => 20],
            [['book_img'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iid' => 'Iid',
            'book_id' => 'Book ID',
            'user_id' => 'User ID',
            'book_name' => 'Book Name',
            'book_img' => 'Book Img',
        ];
    }
}
