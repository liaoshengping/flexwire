<?php

namespace Liaosp\Flexwire\Http\Form;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Liaosp\Flexwire\Services\Form;
use Liaosp\Flexwire\Services\FormInterface;

class LoginForm extends Form implements FormInterface
{

    public function handle()
    {
        $username = request()->input('username');
        $password = request()->input('password');

        if (Auth::attempt([
            'username' => $username,
            'password' => $password,
        ])){
            return $this->success('登录成功','/h5/home/index');
        }




       return $this->fail('用户名或密码错误');
    }


    public function form()
    {
       $this->text('username','用户名/邮箱');
       $this->text('password','密码');
       $this->submit('登录','','info');
    }
}
