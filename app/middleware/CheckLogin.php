<?php
declare (strict_types = 1);

namespace app\middleware;

class CheckLogin
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //
        $path = explode('/', $request->pathinfo());
        if($path[1] != 'login'){
            $token = $request->header('Authorization');
            if($token){
                $jwt = new \Jwt();
                $userId = $jwt->verifyToken($token);
                if(!$userId){
                    return json(['res'=>401, 'data'=>'请重新登入']);
                }else{
                    //return json(['res'=>401, 'data'=>'请重新登入']);
                    return $next($request);
                }
            }else{
                return json(['res'=>401, 'data'=>'请重新登入']);
            }
        }else{
            return $next($request);
        }
    }
}
