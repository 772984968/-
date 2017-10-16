<?php
namespace lib\wealth;

use lib\models\UserCreditsLog;

class Credits extends BaseWealth
{   public $userModel;   // 用户模型
    public $userId;  // 用户id
    public $total = 1000; // 每日总经验
    public $max_credits = 21000;// 总经验值
    public $redis_key = 'credits';// redis key前缀
    public $redis;  // redis 实例
    public $invite = 100;// 邀请会员
    public $live = 100; // 直播
    public $sharing = 20;  // 分享经验
    public $praise = 10; // 点赞积分
    public $praise_limit = 100;   // 点赞限制
    public $comment = 10;// 评论积分
    public $comment_limit = 100; // 评论限制
    public function __construct($user_id=0)
    {

     // 来源类型0签到1邀请会员2直播3分享4点赞5发表评论6刷礼物
      $this->userModel = \Yii::$app->factory->getuser($user_id);
      $this->userId=\Yii::$app->factory->getuser()->userId;
      $this->redis = \Yii::$app->redis;
    }
    // 发表评论
    public function comment()
    {
        $score = $this->cheackday(5);
        if (! $score) {
            return true;
        }
        $comment = $this->comment; // 点赞积分
        $comment_credits = $comment >= $score ? $score : $comment; // 查看积分余额
        $comment_total = $this->redis->hget($this->redis_key . $this->userId, 'comment'); // 点赞总分
        if ($comment_total >= $this->comment_limit) {
            return true;
        }

        if (($comment_credits + $comment_total) > $this->comment_limit) {
            $comment_credits = $this->comment_limit- $comment_total;
        }
        // 开启事务
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            // 用户表
            $this->userModel->credits = $this->userModel->credits + $comment_credits;
            if (! $this->userModel->save())
                throw new \Exception();
            // 日志表
            if (! $this->log($this->userId, 5, $comment_credits, '评论经验'))
                throw new \Exception();
            $transaction->commit();
            $this->addredis(5, $comment_credits); // 添加redis
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }
    // 签到
    public function sign()
    {

      $score = $this->cheackday(0);
        if ($score===false) {
            $this->error = '今天已经签到过了!';
            return false;
        }
        $signModel = new \lib\models\Sign(); // 签到模型
        $signsetting = new \lib\models\Signsetting(); // 积分规则类
        $sign = $signModel->find()
            ->where([
            'user_id' => $this->userId
        ])
            ->one();
         $today =  mktime(4,0,0,date('m'),date('d')+1,date('Y'));
        // 首次签到
        if (! $sign) {
            $signModel->user_id = $this->userId;
            $signModel->last_signtime = $today;
            $signModel->total = 1;
            $signModel->continue_day = 0;
            $signModel->sign_day = 1;
            $sign_credits = $signsetting->find()
                ->
            // 获取签到积分
            where([
                'sign_day' => 1, // 签到次数
                'continue_day' => 0 // 非连续签到
            ])
                ->select('credits')
                ->one();
            $sign_credits = $sign_credits->credits;
            if ($sign_credits) {
                $credits = $sign_credits >= $score ? $score : $sign_credits; // 获取签到积分
                $signModel->credits = $credits;
                $signModel->total_credits = $credits;
            }
            // 开启事务
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                // 签到表
                if (! $signModel->save())
                    throw new \Exception();
                // 签到记录表
                $signdate = new \lib\models\Signdate();
                if (! $signdate->insertdate($signModel->attributes['iid'], $today))

                    throw new \Exception();
                // 用户表
                $this->userModel->credits = $this->userModel->credits + $credits;
                if (! $this->userModel->save())

                    throw new \Exception();
                // 日志表
                if (! $this->log($this->userId, 0, $credits, '签到积分'))

                    throw new \Exception();
                $transaction->commit();
                $this->addredis(0, $credits); // 添加redis
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                $this->error = $e->getMessage();
                return false;
            }
        } // 非首次签到
          else {
            $last_day = $sign->last_signtime;
            // 判断今天是否签到
            if ($last_day == $today) {
                $this->error = '今天已经签到过了';
                return false;
            }
            if (($today - $last_day) <= 86400) {
                // 小于一天，连续签到
                $sign_day = $sign->sign_day + 1;
                $rs = $signsetting->find()
                    ->where([
                    'sign_day' => $sign_day,
                    'continue_day' => 0
                ])
                    ->orWhere([
                    'and',
                    'sign_day<=' . $sign_day,
                    'continue_day=1'
                ])
                    ->select('credits')
                    ->one();
                $sign->sign_day = $sign->sign_day + 1;
                $key = 1;
            } else {
                // 非连续签到
                $rs = $signsetting->find()
                    ->where([
                    'sign_day' => 1,
                    'continue_day' => 0
                ])
                    ->select('credits')
                    ->one();
                $sign->sign_day = 1;
                $sign->continue_day = $sign->continue_day + 1;
                $key = 0;
            }
            $sign->total = $sign->total + 1;
            $sign->last_signtime = $today;

            if ($rs) {
                $sign_credits = $rs->credits;
                $credits = $sign_credits >= $score ? $score : $sign_credits; // 获取签到积分
                $sign->credits = $credits;
                $sign->total_credits = $sign->total_credits + $credits;
            }

            // 开启事务
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                // 签到表
                if (! $sign->save())
                    throw new \Exception();
                // 签到记录表
                $signdate = new \lib\models\Signdate();
                if (! $signdate->insertdate($sign->iid, $today, $key))
                    throw new \Exception();
                // 用户表
                $this->userModel->credits = $this->userModel->credits + $credits;
                if (! $this->userModel->save())
                    throw new \Exception();
                // 日志表
                if (! $this->log($this->userId, 0, $credits, '签到积分'))
                    throw new \Exception();
                $transaction->commit();
                $this->addredis(0, $credits); // 添加redis
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                $this->error = $e->getMessage();
                return false;
            }
        }

        return true;
    }
    // 刷礼物
    public function gift($number, $giver_userid=0)
    {
        $score = $this->cheackday(6);
        if (! $score) {
            return true;
        }

        $gift_credits = $number >= $score ? $score : $number; // 查看积分余额
                                                              // 开启事务
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            // 用户表
            $this->userModel->credits = $this->userModel->credits + $gift_credits;
            if (! $this->userModel->save())
                throw new \Exception();
            // 日志表
            if (! $this->log($this->userId, 6, $gift_credits, '刷礼物积分give', $giver_userid))
                throw new \Exception();
            $transaction->commit();
            $this->addredis(6, $gift_credits); // 添加redis
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }
    // 用户点赞
    public function praise()
    {
        $score = $this->cheackday(4);
        if (! $score) {
            return true;
        }
        $praise = $this->praise; // 点赞积分
        $praise_credits = $praise >= $score ? $score : $praise; // 查看积分余额
        $praise_total = $this->redis->hget($this->redis_key . $this->userId, 'praise'); // 点赞总分
        if ($praise_total >= $this->praise_limit) {
            return true;
        }

        if (($praise_credits + $praise_total) > $this->praise_limit) {
            $praise_credits = $this->praise_limit - $praise_total;
        }
        // 开启事务
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            // 用户表
            $this->userModel->credits = $this->userModel->credits + $praise_credits;
            if (! $this->userModel->save())
                throw new \Exception();
            // 日志表
            if (! $this->log($this->userId, 4, $praise_credits, '点赞积分'))
                throw new \Exception();
            $transaction->commit();
            $this->addredis(4, $praise_credits); // 添加redis
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }
    // 分享
    public function sharing()
    {
        $score = $this->cheackday(3);
        if (! $score) {
            return true;
        }

        $sharing = $this->sharing;
        $sharing_credits = $sharing >= $score ? $score : $sharing; // 分享积分
                                                                   // 开启事务
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            // 用户表
            $this->userModel->credits = $this->userModel->credits + $sharing_credits;
            if (! $this->userModel->save())
                throw new \Exception();
            // 日志表
            if (! $this->log($this->userId, 3, $sharing_credits, '分享积分'))
                throw new \Exception();
            $transaction->commit();
            $this->addredis(3, $sharing_credits); // 添加redis
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }
    // 邀请会员
    public function invitemembers($invite_userid)
    {
        $userModel = $this->userModel;
        $score = $this->cheackday(1);
        if (! $score) {
            return true;
        }
        $invite = $this->invite;
        $invite_credits = $invite >= $score ? $score : $invite; // 获取邀请会员积分
        $transaction = \Yii::$app->db->beginTransaction();  // 开启事务
        try {
            // 用户表
            $this->userModel->credits = $this->userModel->credits + $invite_credits;
            if (! $this->userModel->save())
                throw new \Exception();
            // 日志表
            if (! $this->log($this->userId, 1, $invite_credits, '邀请会员' . $invite_userid, $invite_userid))
                throw new \Exception();
            $transaction->commit();
            $this->addredis(1, $invite_credits); // 添加redis
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }
    // 直播
    public function live($leng)
    {
        $score = $this->cheackday(2);
        // 判断总积分和直播时长
        if (! $score) {
            return true;
        }
        if ( $leng <= 1) {
            $this->error='直播时长不够！';
            return false;
        }

        $live = $this->live;
        $live_credits = $live >= $score ? $score : $live; // 获取邀请会员积分
                                                          // 开启事务
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            // 用户表
            $this->userModel->credits = $this->userModel->credits + $live_credits;
            if (! $this->userModel->save())
                throw new \Exception();
            // 日志表
            if (! $this->log($this->userId, 2, $live_credits, '直播时间'.$leng))
                throw new \Exception();
            $transaction->commit();
            $this->addredis(2, $live_credits); // 添加redis
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }
    // 写入redis
    public function addredis($type, $score)
    {
        $redis = $this->redis;
        // 用户签到
        if ($type == 0) {
            if (! $redis->hexists($this->redis_key . $this->userId, 'sign')) {
                $redis->hset($this->redis_key . $this->userId, 'sign', $score);
            } else {
                return false;
            }
        }
        //邀请用户
        if ($type == 1) {
            if (! $redis->hexists($this->redis_key . $this->userId, 'invite')) {
                $redis->hset($this->redis_key . $this->userId, 'invite', $score);
            } else {
                $redis->hincrby($this->redis_key . $this->userId, 'invite', $score);
            }
        }
        //用户直播
        if ($type == 2) {
            if (! $redis->hexists($this->redis_key . $this->userId, 'live')) {
                $redis->hset($this->redis_key . $this->userId, 'live', $score);
            } else {
                return  false;

            }
        }
        //用户分享
        if ($type == 3) {
            if (! $redis->hexists($this->redis_key . $this->userId, 'sharing')) {
                $redis->hset($this->redis_key . $this->userId, 'sharing', $score);
            } else {
                return  false;

            }
        }
        //用户点赞
        if ($type == 4) {
                        $redis->hincrby($this->redis_key . $this->userId, 'praise', $score);
        }
        //用户评论
        if ($type == 5) {
                         $redis->hincrby($this->redis_key . $this->userId, 'comment', $score);
        }
        //刷礼物
        if ($type == 6) {
            if (! $redis->hexists($this->redis_key . $this->userId, 'gift')) {
                $redis->hset($this->redis_key . $this->userId, 'gift', $score);
            } else {
                $redis->hincrby($this->redis_key . $this->userId, 'gift', $score);

            }
        }
        $redis->hincrby($this->redis_key . $this->userId, 'total', $score);
    }
    // 检查每日积分上限
    public function cheackday($type)
    {
        //查询用户总积分
        if ($this->userModel->credits>$this->max_credits)
            return 0;
            $redis = $this->redis;
        if (! $redis->hexists($this->redis_key . $this->userId, 'total')) {
            $redis->hset($this->redis_key . $this->userId, 'total', 0);
            $redis->expireat($this->redis_key . $this->userId,mktime(4,0,0,date('m'),date('d')+1,date('Y'))); // 设置过期时间
            $redis->hset($this->redis_key.$this->userId,'praise',0);
            $redis->hset($this->redis_key.$this->userId,'comment',0);
            return $this->total;
        }
        $today_total = $redis->hget($this->redis_key . $this->userId, 'total'); // 当日总签到积分
        if ($today_total >= $this->total) {
            return 0;
        }
        // 用户签到
        if ($type == 0) {
            if ($redis->hexists($this->redis_key.$this->userId, 'sign'))
                return false;
       }
       //用户直播
       if ($type == 2) {
           if ($redis->hexists($this->redis_key.$this->userId, 'live'))
               return false;
       }
       //用户分享
       if ($type == 3) {
           if ($redis->hexists($this->redis_key.$this->userId, 'sharing'))
               return false;
       }
       //返回可添加积分
        return $this->total-$today_total;
    }
   // 添加日志
    public function log($user_id, $type, $numbers, $note = '', $source_user_id = 0)
    {
        $log = new UserCreditsLog();
        $log->user_id = $user_id;
        $log->note = $note;
        $log->type = $type; // 来源类型0签到1邀请会员2直播3分享4点赞5发表评论6刷礼物
        $log->number = $numbers;
        $log->source_user_id = $source_user_id;
        if ($log->save()){
                return true;
        }else{
            return false;
        }
    }

}
