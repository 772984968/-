<?phpnamespace lib\models;use Yii;/** * This is the model class for table "at_account_level". * * @property integer $iid * @property string $name * @property integer $credits * @property integer $withdrawal_proportion */class BaseModel extends \yii\db\ActiveRecord{    const LIST_CACHE_NAME = '';    const NUMBER_NAME = '';    //通过积分获取对应的等级    public static function numberToRecord( $credits )    {        $data = self::getCacheList();        if( $data ) {            foreach($data as $row) {                if($credits >= $row[static::NUMBER_NAME]) {                    return $row;                }            }        }        return json_decode('{}');    }    //取列表数据并缓存    public static function getCacheList($fields = '*', $order = 'DESC')    {        $cache = Yii::$app->getCache();        $data = $cache->get(self::LIST_CACHE_NAME);        if( !$data ) {            $data = self::find()                ->select($fields)                ->orderBy(static::NUMBER_NAME.' '.$order)                ->asArray()                ->all();            $cache->set(static::LIST_CACHE_NAME, $data);        }        return $data;    }    //消除缓存    public static function clearListCache()    {        Yii::$app->getCache()->delete(static::LIST_CACHE_NAME);    }    //取缓存中 id 序号行    public static function getCacheRow( $id ) {        $key = static::primaryKey()[0];        $data = static::getCacheList();        foreach($data as $row) {            if($row[$key] == $id) {                return $row;            }        }        return false;    }    public function init()    {        $this->on(self::EVENT_AFTER_INSERT, [$this, 'clearListCache']);        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'clearListCache']);        $this->on(self::EVENT_AFTER_DELETE, [$this, 'clearListCache']);    }    //取列表键值对    public static function getKeyName()    {        $key = static::primaryKey()[0];        $list = static::getCacheList();        $new_list = [];        if($list)        {            foreach($list as $row)            {                $new_list[$row[$key]] = $row['name'];            }        }        return $new_list;    }}