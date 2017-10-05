<?php
namespace lib\nodes;
class Curl
{
    private $curl;
    public function __construct()
    {
        //date_default_timezone_set('RPC');
        $this->curl = curl_init();
    }
    
    public function post($data,$url)
    {
        $data = http_build_query($data);
        curl_setopt($this->curl,CURLOPT_URL,$url);
        curl_setopt($this->curl,CURLOPT_HEADER,0);
        curl_setopt($this->curl,CURLOPT_POST,1);
        curl_setopt($this->curl,CURLOPT_POSTFIELDS,$data);
        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);
        $return = curl_exec($this->curl);
        if( !curl_errno($this->curl) ) {
            echo $return;
        } else {
            return false;
        }
    }

    public function get($url)
    {
        curl_setopt($this->curl,CURLOPT_URL,$url);
        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);
        $output = curl_exec($this->curl);
        return $output;
    }

    public function gets($url)
    {
        curl_setopt($this->curl,CURLOPT_URL,$url);
        curl_setopt($this->curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);
        $output = curl_exec($this->curl);
        return $output;
    }

    public function posts($data,$url)
    {
        $data = http_build_query($data);
        curl_setopt($this->curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($this->curl,CURLOPT_URL,$url);
        curl_setopt($this->curl,CURLOPT_HEADER,0);
        curl_setopt($this->curl,CURLOPT_POST,1);
        curl_setopt($this->curl,CURLOPT_POSTFIELDS,$data);
        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);
        $return = curl_exec($this->curl);
        if( !curl_errno($this->curl) ) {
            echo $return;
        } else {
            return false;
        }
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    public function upload_file($img,$url){

        $fields['file'] = new \CURLFile($img);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);


        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);

    }
}
?>