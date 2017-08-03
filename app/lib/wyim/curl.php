<?phpnamespace lib\wyim;use yii\extend\AdCommon;class curl{    private $curl;    const APP_KEY = 'd41c9fbcccebd61dd1497c90fc69f554';    const APP_SECRET = 'ea815ecdd7f6';    public function __construct()    {        //date_default_timezone_set('RPC');        $Nonce = AdCommon::randomkeys(20);        $CurTime = time();        $this->curl = curl_init();        $header = [];        $header[] = 'Content-Type:application/x-www-form-urlencoded;charset=utf-8';        $header[] = 'AppKey:'.static::APP_KEY;        $header[] = 'Nonce:'.$Nonce;        $header[] = 'CurTime:'.$CurTime;        $header[] = 'CheckSum:'. sha1(self::APP_SECRET . $Nonce . $CurTime);        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);    }    public function post($data,$url)    {        $data = http_build_query($data);        curl_setopt($this->curl,CURLOPT_URL,$url);        curl_setopt($this->curl,CURLOPT_HEADER,0);        curl_setopt($this->curl,CURLOPT_POST,1);        curl_setopt($this->curl,CURLOPT_POSTFIELDS,$data);        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);        $return = curl_exec($this->curl);        if( !curl_errno($this->curl) ) {            return $return;        } else {            return false;        }    }    public function get($url)    {        curl_setopt($this->curl,CURLOPT_URL,$url);        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);        $output = curl_exec($this->curl);        return $output;    }    public function gets($url)    {        curl_setopt($this->curl,CURLOPT_URL,$url);        curl_setopt($this->curl,CURLOPT_SSL_VERIFYPEER,false);        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);        $output = curl_exec($this->curl);        return $output;    }    public function posts($data,$url)    {        $data = http_build_query($data);        curl_setopt($this->curl,CURLOPT_SSL_VERIFYPEER,false);        curl_setopt($this->curl,CURLOPT_URL,$url);        curl_setopt($this->curl,CURLOPT_HEADER,0);        curl_setopt($this->curl,CURLOPT_POST,1);        curl_setopt($this->curl,CURLOPT_POSTFIELDS,$data);        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);        $return = curl_exec($this->curl);        if( !curl_errno($this->curl) ) {            return json_decode($return);        } else {            return false;        }    }    public function __destruct()    {        curl_close($this->curl);    }}