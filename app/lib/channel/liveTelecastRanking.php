<?phpnamespace lib\channel;use lib\models\User;//直播排行class liveTelecastRanking{    public static function addDiamond($user_id, $number)    {        rankingHour::addDiamond($user_id, $number);        rankingDay::addDiamond($user_id, $number);        rankingWeek::addDiamond($user_id, $number);        rankingMonth::addDiamond($user_id, $number);        matchRanking::addDiamond($user_id, $number);        ranking::addDiamond($user_id, $number);    }}