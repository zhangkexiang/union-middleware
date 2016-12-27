<?php
require __DIR__ . '/../vendor/autoload.php';

//模拟 laravel环境
class TempResp{
    public function json($param1, $param2, $param3, $param4){
        echo 'no pass';
//        var_dump(compact('param1','param2','param3','param4'));
    }
}
class TempReq{
    public function path(){
        return '4/user/login';
    }
}
function response(){
    return new TempResp();
}

use Union\Mid\CheckSignMiddleware;
$tmp = new CheckSignMiddleware();
$tmp->handle(new TempReq(),function($request){echo 'pass';});
