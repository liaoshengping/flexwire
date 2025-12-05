<?php

namespace Liaosp\Flexwire\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Liaosp\Flexwire\Services\ToolService;

class H5Auth
{
    public $notLogin = [
        'flexwire/h5/register/emailRegister',
        'flexwire/h5/login/forgetPassword',
        'flexwire/h5/login/resetPassword',
        'flexwire/h5/login/index',
        'flexwire/get-service2',  #单独处理
    ];

    public function handle(Request $request, \Closure $next){

        $needAuth = true;
        # 交互接口
        if ($request->path() == 'flexwire/get-service2'){
            $class_name = $request->input('class_name');
            $className = (new ToolService())->decode($class_name);
            $notAuthClass = config('flexwire.not_auth_class');
            if (in_array($className, $notAuthClass)){
                $needAuth = false;
            }
            if ($needAuth && !Auth::check()){
                throw new \Exception('请先登录');
            }
        }



        if (!Auth::check() && !in_array($request->path(), $this->notLogin) ){
            return redirect('/flexwire/h5/login/index');
        }



        return $next($request);
    }

}
