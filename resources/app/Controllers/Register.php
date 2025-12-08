<?php

namespace App\FlexWire\Controllers;

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
            $content->add(new \Liaosp\Flexwire\Http\Form\RegisterForm());
        } else {
            $content->add(new \Liaosp\Flexwire\Http\Form\RegisterEmailForm());
        }
        $content->block();
        if ($email) {
            $content->add(Button::make('重新获取验证码')->typeInfo()->plain()->href('/flexwire/h5/register/emailRegister'));
        }
        $content->add(Button::make('已有账号？去登录')->typeInfo()->plain()->href('/flexwire/h5/login/index'));
        return $content;
    }

}
