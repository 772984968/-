<?php
namespace lib\nodes;
class Easemob
{
    private $curl;
    private $token;
    private $org_name='1118170323115067';
    private $app_name='cyj';
    private $client_id='YXA6IBf60A-MEee1J9MGYvv3Yg';
    private $client_secret='YXA6GwAATwRA3k-VDDpRchpTjfoNixc';
    private $url='https://a1.easemob.com/';
    public function __construct()
    {
        $this->curl = new Curl();
    }

    public function get($url)
    {
        print($this->curl->get($url));
    }

    public function gettoken()
    {
       $url = $this->url . $this->org_name . '/' . $this->app_name . '/token';
        echo $url;die;
       $data =  [
                    "grant_type"=>"client_credentials",
                    "client_id"=>$this->client_id,
                    "client_secret"=>$this->client_secret
                ];
        $result = $this->curl->posts($data,$url);
        var_dump( $result );
    }
}