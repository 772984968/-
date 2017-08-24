<?phpnamespace lib\wyim;class wyim{    private static $curl = null;    public static $error = '';    public static function getCurl()    {        if(!static::$curl) {            static::$curl = new curl();        }        return static::$curl;    }    public static function createAccid($user)    {        $url = 'https://api.netease.im/nimserver/user/create.action';        $data = [            'accid' => $user['username'],            'name' => $user['username'],            'icon' => \Yii::$app->params['webpath'] . '\uploads\default_head.png',        ];        $result = static::getCurl()->posts($data, $url);        if( isset($result->code) && $result->code == 200 ) {            //成功            return $result->info;        } else {            static::$error = json_encode($result);            return false;        }    }    public static function updateUinfo($data)    {        $url = 'https://api.netease.im/nimserver/user/updateUinfo.action';        $result = static::getCurl()->posts($data, $url);        if( isset($result->code) && $result->code == 200 ) {            //成功            return true;        } else {            static::$error = json_encode($result);            return false;        }    }}