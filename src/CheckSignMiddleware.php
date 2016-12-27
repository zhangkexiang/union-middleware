<?php

namespace Union\Mid;

/**
 * Created by PhpStorm.
 * User: kexiangzhang
 * Date: 16/12/27
 * Time: 上午10:09
 */
use Closure;
use Union\Mid\BaseMiddleware;

class CheckSignMiddleware extends BaseMiddleware
{

    protected function match($request){

        $inputs = request()->all();
        $conf = union_config('union.mid.sign.headers',[]);


        foreach ($conf as $v){
            $inputs[$v]=request()->header($v,'');
        }
        $sign = '';
        if(isset($inputs['sgin'])){
            $sign = $inputs['sign'];
            unset($inputs['sign']);
        }
        ksort($inputs);

        $sourceStr = '';
        foreach ($inputs as $k => $v) {
            $sourceStr .= $k . "=" . $v;
        }

        $os = request()->header('os','');
        $secret = union_config('union.mid.sign.'.$os,[]);

        $check1 = md5($this->getSourceStr() . md5($secret['first']) . $secret['second']);

        if($check1==$sign){
            return '';
        }else{
            return [
                "code" => 500,
                "detail" => "签名验证失败",
                "data"=>[]
            ];
        }
    }

}