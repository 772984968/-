<?php
namespace app\controllers;
use lib\nodes\Rpc;
use yii\web\Controller;
use Yii;

class IndexController extends Controller
{

    public function actionIndex()
    {
        /*$input = json_encode(['class'=>'User','method'=>'findOne', 'parameter'=>4]);
        $result = \lib\nodes\Rpc::execute($input);
        var_dump($result);*/
    }

    public function actionHttprpc()
    {
        $c = Yii::$app->getRequest()->post('c');
        $m = Yii::$app->getRequest()->post('m');
        $p = Yii::$app->getRequest()->post('p');
        $input = [
            'class' => $c,
            'method' => $m,
            'parameter' => $p,
        ];
        $result = \lib\nodes\Rpc::execute($input);
        if($result) {
            echo json_encode(['code'=>200, 'data'=>$result, 'msg'=>'']);
        } else {
            echo json_encode(['code'=>400, 'data'=>'', 'msg'=>Rpc::$error]);
        }
        die;
    }

    public function actionRpc(){
        $host = "192.168.31.109";
        $port = 6060;
        set_time_limit(0);


        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

        $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");

        $result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

        while(1) {
            $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");

            $input = socket_read($spawn, 1024) or die("Could not read input\n");

            $result = \lib\nodes\Rpc::execute($input);

            if($result) {
                $output = json_encode(['code'=>200, 'data'=>$result, 'msg'=>'']);
            } else {
                $output = json_encode(['code'=>400, 'data'=>'', 'msg'=>Rpc::$error]);
            }
            socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");

        }

        socket_close($spawn);

        socket_close($socket);
        echo 'close';
    }


}