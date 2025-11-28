<?php

namespace Liaosp\Flexwire\Http\Controllers;

use App\H5\Form\LoginForm;
use App\H5\Form\RegisterEmailForm;
use App\H5\Form\RegisterForm;
use Liaosp\Flexwire\Component\Button;
use Liaosp\Flexwire\Layout\Column;
use Liaosp\Flexwire\Layout\Content;
use Liaosp\Flexwire\Layout\Row;

class Register
{
    //正常的账号密码注册逻辑
//    public function index()
//    {
//        return Content::make()
//            ->title('注册')
//            ->block()
//            ->block()
//            ->add(new RegisterForm())
//            ->block()
//            ->add(Button::make('已有账号？去登录')->typeInfo()->href('/h5/login/index'))
//            ->render();
//    }

    //获取验证码
    public function emailRegister()
    {
        $email = request()->input('email', '');
        $content = Content::make()
            ->title('注册')
            ->block();
        if ($email) {
            $content->add(new RegisterForm());
        } else {
            $content->add(new RegisterEmailForm());
        }
        $content->block();
        if ($email) {
            $content->add(Button::make('重新获取验证码')->typeInfo()->plain()->href('/h5/register/emailRegister'));
        }
        $content->add(Button::make('已有账号？去登录')->typeInfo()->plain()->href('/h5/login/index'));
        return $content;
    }

}
