<?phpnamespace lib\channel;use lib\models\Gift as GiftModel;use lib\models\Channel;use lib\wyim\chatroom;use lib\models\User;use Yii;use lib\models\AccountLevel;class gift{    public static $error;    public static function send($userId, $receiverId, $payType, $payNumber)    {        if($userId == $receiverId) {            static::$error = '不能赠送礼物给自己';            return false;        }        $gift = GiftModel::getCacheRow($payType);        //礼物是否存在        if(!$gift) {            static::$error = '礼物不存在';            return false;        }        if($payNumber < 1) {            static::$error = '礼物数量不能小于1';            return false;        }        $ChannelModel = Channel::findOne(['user_id'=>$receiverId]);        //取主播间        if(!$ChannelModel) {            static::$error = '主播间不存在';            return false;        }        //取用户        $userModel = User::findOne($userId);        if(!$userModel) {            static::$error = '用户不存在';            return false;        }        if($gift['diamond']>0) {            //计算数量            $diamond_number = $gift['diamond'] * $payNumber;            if($userModel->vip_type) {                $diamond_number *= 0.9;            }            if($diamond_number <= 0) {                static::$error = '礼物需要的钻石数量异常';                return false;            }            /**            //取可以拿到的比例            $send_gify_scale = \lib\models\Setting::keyTovalue('send_gify_scale');            **/            //按等级提取比例            $send_gify_scale = AccountLevel::liveearn($userModel->credits);            $receive_number = round($diamond_number * $send_gify_scale, 2);            //取接收者            if(!$receiverId) {                static::$error = '接收人参数错误';                return false;            }            $receiverModel = User::findOne($receiverId);            if(!$receiverModel) {                static::$error = '接收人不存在';                return false;            }            $t = Yii::$app->getDb()->beginTransaction();            //减去相应的钻石            $diamondClass = Yii::$app->factory->getwealth('diamond', $userModel);            if(!$diamondClass->sub([                'type' => \Config::DIAMOND_SEND_GIFY,                'number' => $diamond_number,                'note' => '赠送'.$payNumber.$gift['name']            ])){                $t->rollBack();                static::$error = $diamondClass->error;                return false;            }            //接收人增加收益            if(!Yii::$app->factory->getwealth('diamond', $receiverModel)->add([                'type' => \Config::DIAMOND_SEND_GIFY,                'number' => $receive_number,                'note' => '赠送'.$payNumber.$gift['name']            ])) {                static::$error = '赠送礼物失败';                $t->rollBack();                return false;            };            //添加到赠送礼物日志            $gifyLogModel = new \lib\models\GifyLog();            $gifyLogModel->attributes = [                'user_id' => $userId,                'receiver_id' => $receiverId,                'gify_name' => $gift['name'],                'gify_number' => $payNumber,                'gify_price' => $diamond_number,                'scale' => $send_gify_scale,                'price' => $receive_number,            ];            if(!$gifyLogModel->save()) {                \lib\models\CodeLog::addlog('赠送礼物日志表添加失败！',$gifyLogModel->errors);                static::$error = '记录添加失败';                $t->rollBack();                return false;            }            $t->commit();            //计入到排名            \lib\channel\liveTelecastRanking::addDiamond($receiverId, $receive_number);            //发送群消息            $grade =  \lib\channel\matchRanking::getGrade($receiverId) ?: \lib\channel\ranking::getGrade($receiverId);            $result = [                'gift_type' => $payType-1,                'gift_number' => $payNumber,                'grade' => (string)$grade,            ];            chatroom::sendGift($ChannelModel->roomid, $userModel, $result);            return $userModel->getWealth();        }        elseif($gift['beans']>0)        {            //计算数量            $beans_number = $gift['beans'] * $payNumber;            if($beans_number <= 0) {                static::$error = '礼物需要的人气豆数量异常';                return false;            }            //取接收者            if(!$receiverId) {                static::$error = '接收人参数错误';                return false;            }            $receiverModel = User::findOne($receiverId);            if(!$receiverModel) {                static::$error = '接收人不存在';                return false;            }            $t = Yii::$app->getDb()->beginTransaction();            //减去相应的人气豆            $diamondClass = Yii::$app->factory->getwealth('beans', $userModel);            if(!$diamondClass->sub([                'type' => \Config::DIAMOND_SEND_GIFY,                'number' => $beans_number,                'note' => '赠送'.$payNumber.$gift['name']            ])){                $t->rollBack();                static::$error = $diamondClass->error;                return false;            }            $t->commit();            //计入到排名            \lib\channel\liveTelecastRanking::addDiamond($receiverId, $beans_number/10);            //发送群消息            $grade =  \lib\channel\matchRanking::getGrade($receiverId) ?: \lib\channel\ranking::getGrade($receiverId);            $result = [                'gift_type' => $payType-1,                'gift_number' => $payNumber,                'grade' => (string)$grade,            ];            chatroom::sendGift($ChannelModel->roomid, $userModel, $result, '6');            return $userModel->getWealth();        }  }}