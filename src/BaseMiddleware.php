<?php

namespace Union\Mid;

/**
 * Created by PhpStorm.
 * User: kexiangzhang
 * Date: 16/12/27
 * Time: 上午10:09
 */
use Closure;

class BaseMiddleware
{
//  校验入口 
    public function handle($request, Closure $next)
    {
        //判断是否为 免校验路径
        if($this->shouldPassThrough($request)){
            return $next($request);
        }
        //匹配规则 成功则继续 错误则返回匹配错误消息
        $result = $this->match($request);
        if($result === ''){
            return $next($request);
        }else {
            return $this->noMatch($result);
        }

    }

    /**
     * 被子类重写覆盖 此处为例子 随机校验成功失败
     */
    protected function match($request){
        $tmp = rand(1,6);
        echo $tmp;
        if($tmp<3){
            return [
                "code" => 500,
                "detail" => "模版匹配失败",
                "data"=>[]
            ];
        }else{
            return '';
        }
    }
    // 过滤 匹配失败 返回信息
    protected function noMatch($result=null){
        if($result==null){
            $result=[
                "code" => 500,
                "detail" => "请求被拦截",
                "data"=>[]
            ];
        }
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * 定义全局中间件中过滤掉的路由
     * 把指定路由忽略
     */
    public function shouldPassThrough($request){
//      获取 不校验路径
        $excepturlarr = union_config('union.mid.excepturl',[]);

        $path = $request->path();   // 例:3/user/login
        if(in_array($path, $excepturlarr)) {
            return true;
        }
        return false;

    }
}