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
        if(isset($inputs['sign'])){
            $sign = $inputs['sign'];
            unset($inputs['sign']);
        }
        ksort($inputs);
        $sourceStr = '';
        foreach ($inputs as $k => $v) {
            $sourceStr .= $k . "=" . $v;
        }

        $os = request()->header('os','android');
//        var_dump('union.mid.sign.secret.'.$os);
//        union.mid.sign.secret.android
        $secret = union_config('union.mid.sign.secret.'.$os,[]);
//var_dump($secret);die;
        $check1 = md5($sourceStr. md5($secret['first']) . $secret['second']);
//echo $check1;
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