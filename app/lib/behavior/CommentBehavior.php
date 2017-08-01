<?php
namespace lib\behavior;

class CommentBehavior extends \yii\base\Behavior
{
    //点赞加1
    public function praiseAdd($id,$num=1)
    {
        $result = $this->owner->findOne($id);
        if( $result ) {

            $result->praise_number += $num;
            $result->save();
        }
    }

    //点赞减1
    public function praiseSub($id,$num=1)
    {
        $result = $this->owner->findOne($id);
        if( $result ) {
            $result->praise_number -= $num;
            $result->save();
        }
    }

    //评论加1
    public function commentAdd($id,$num=1){
        $result = $this->owner->findOne($id);
        if( $result ) {
            $result->comment_number += $num;
            $result->save();
        }
    }

    //评论减1
    public function commentSub($id,$num=1){
        $result = $this->owner->findOne($id);
        if( $result ) {
            $result->comment_number -= $num;
            $result->save();
        }
    }
}

?>