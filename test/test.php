<?php
require __DIR__ . '/../vendor/autoload.php';

putenv('APP_MID_CONTROL=true');//设置环境变量

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
    public function all(){
        return ['sign'=>'d4c4d95b65cee9d2bce1e4722d9092ba'];
    }
    public function header($k,$v){
        $tmp = [
            'app'=>'wo',
            'xqid'=>'',
            'os'=>'',
            'timestamp'=>'',
            'token'=>'',
            'version'=>'',
            'uid'=>''
        ];
        return $tmp[$k]==''?$v:$tmp[$k];
    }
}
function request(){
    return new TempReq();
}
function response(){
    return new TempResp();
}
use Union\Mid\CheckSignMiddleware;
$tmp = new CheckSignMiddleware();
$tmp->handle(new TempReq(),function($request){echo 'pass';});
