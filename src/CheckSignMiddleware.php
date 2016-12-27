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
        $tmp = rand(1,6);
        echo $tmp;
        if($tmp<3){
            echo '不通过测试';
            return [
                "code" => 500,
                "detail" => "测试不通过",
                "data"=>[]
            ];
        }else{
            echo '通过测试';
            return '';
        }
    }

}