<?php
namespace lib\vendor\easemob;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;

class Easemob
{

	var $_easemoburl = 'https://a1.easemob.com/1118170323115067/cyj';



    /**
	 * 注册环信
	 * @param type $mobile
	 * @param string $msg
	 * @return type
	 */
    
    public function registerToken($nikename,$pwd)
    {
    	$formgettoken=$this->_easemoburl."/users";
    	
    	$body=array(
    			"username"=>$nikename,
    			"password"=>$pwd,
    	);
    	$patoken=json_encode($body);
    	$header = array($this->_get_token());
    	$arrayResult = $this->_curl_request($formgettoken,$patoken,$header);
    	//var_dump($res);die();
    	//$arrayResult =  json_decode($res, true);
    	return $arrayResult ;
    }
    //重置用户密码 PUT /{org_name}/{app_name}/users/{username}/password
    function changePwdToken($nikename,$newpwd)
    {
    	$formgettoken=$this->_easemoburl."/users/".$nikename."/password";
    	$body=array(
    			"newpassword"=>$newpwd,
    	);
    	$patoken=json_encode($body);
    	$header = array($this->_get_token());
    	$method = "PUT";
    	$arrayResult = $this->_curl_request($formgettoken,$patoken,$header,$method);

    	//$arrayResult =  json_decode($res, true);
    	return $arrayResult ;
    }
    /**
     * 私信列表
     * @param number $limit
     * @return mixed
     */
    function chatRecord($uid,$cursor='') {
    	$time = strtotime("-2 day");
    	$limit = 5;
    	$ql = "select+*+where+to='$uid'+and+timestamp>'$time'";
    	$formgettoken=$this->_easemoburl."/chatmessages";
    	$ql = ! empty ( $ql ) ? "ql=" . $ql : "order+by+timestamp+desc";
    	$cursor = ! empty ( $cursor ) ? "&cursor=" . $cursor : '';
    	$url = $formgettoken. "?" . $ql . "&limit=" . $limit . $cursor;
    	$header = array($this->_get_token());
    	$res = $this->_curl_request($url,'',$header,$type = 'GET');
//     	var_dump($res);die();
//     	$arrayResult =  json_decode($res, true);
    	return $res ;
    }
	//先获取app管理员token POST /{org_name}/{app_name}/token
	function _get_token()
	{
		$formgettoken=$this->_easemoburl."/token";
		$body=array(
			"grant_type"=>"client_credentials",
			"client_id"=>"YXA6IBf60A-MEee1J9MGYvv3Yg",
			"client_secret"=>"YXA6GwAATwRA3k-VDDpRchpTjfoNixc"
		);
		$patoken=json_encode($body);
		$tokenResult = $this->_curl_request($formgettoken,$patoken);
// 		$tokenResult = array();
		
// 		$tokenResult =  json_decode($res, true);
		//var_dump($tokenResult);
		return "Authorization: Bearer ". $tokenResult["access_token"];	
	}
	function _curl_request($url, $body, $header = array(), $method = "POST")
	{
		$return =array();
		array_push($header, 'Accept:application/json');
		array_push($header, 'Content-Type:application/json');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, $method, 1);
		
		switch ($method){ 
			case "GET" : 
				curl_setopt($ch, CURLOPT_HTTPGET, true);
			break; 
			case "POST": 
				curl_setopt($ch, CURLOPT_POST,true); 
			break; 
			case "PUT" : 
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
			break; 
			case "DELETE":
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
			break; 
		}
		
		curl_setopt($ch, CURLOPT_USERAGENT, 'SSTS Browser/1.0');
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		if (isset($body{3}) > 0) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}
		if (count($header) > 0) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		$ret = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		
		//clear_object($ch);
		//clear_object($body);
		//clear_object($header);
		$return = json_decode($ret, true);
		if ($err || isset($return['error'])) {
			$err = json_decode($err, true);
			$err['status']=0;
			return $err;
			
		}
 		$return['status']=1;
		return $return;
		
	}
}