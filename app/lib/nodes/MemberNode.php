<?phpnamespace lib\nodes;use Yii;use lib\models\Member;use lib\models\AppPower;//用户所属会员类class MemberNode{    const MEMBER_RESULT_CACHE_NAME = 'member_result_cache_';    const MEMBER_POWER_CACHE_NAME = 'member_power_cache_';    //登入后，缓存所有要缓存的内容    public function cache( $member_id )    {        $member = $this->getMember($member_id);        if(!$member) {            return false;        }        $this->cachePower( $member['operates'] );        $this->setMemberCache($member);    }    //缓存用户信息    public function setMemberCache($member)    {        $userid = Yii::$app->factory->getuser()->userId;        Yii::$app->getCache()->set(static::MEMBER_RESULT_CACHE_NAME.$userid, $member);    }    //取会员对应的会员数据    public function getMember($member_id)    {        $member = Member::findOne($member_id);        if(!$member) {            $member = Member::getDefaultMember();                        if(!$member) {                return false;            }        } else {            $member = $member->toArray();        }        return $member;    }    //缓存可用的权限    public function cachePower($ids)    {        $userid = Yii::$app->factory->getuser()->userId;        $powers = AppPower::idToPowers($ids);        Yii::$app->getCache()->set(static::MEMBER_POWER_CACHE_NAME . $userid, $powers);    }    //取会员缓存数据    public function getMemberCache()    {        $userid = Yii::$app->factory->getuser()->userId;        return Yii::$app->getCache()->get('static::MEMBER_RESULT_CACHE_NAME'.$userid);    }    //取会员功能数据    public function getPowerCache()    {        $userid = Yii::$app->factory->getuser()->userId;        return Yii::$app->getCache()->get(static::MEMBER_POWER_CACHE_NAME . $userid);    }    //检测这个会员是否有这个功能    public function checkPower($power)    {        $powers = $this->getPowerCache();                if(in_array($power, $powers)) {            return true;        }        return false;    }}