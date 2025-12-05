<?php

namespace Liaosp\Flexwire\Http\Controllers;

use App\H5\Form\LoginForm;
use Liaosp\Flexwire\Component\Button;
use Liaosp\Flexwire\Http\Form\ForgetPasswordEmailForm;
use Liaosp\Flexwire\Http\Form\ResetPasswordForm;
use Liaosp\Flexwire\Layout\Column;
use Liaosp\Flexwire\Layout\Content;
use Liaosp\Flexwire\Layout\Row;

class Login
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('/flexwire/h5/home/index');
        }

        return Content::make()
            ->title('登录')
            ->block()
            ->add(new \Liaosp\Flexwire\Http\Form\LoginForm())
            ->block()
            ->row(Button::make()->setText('还没账号？去注册')->plain()->href('/flexwire/h5/register/emailRegister'))
            ->row(Button::make()->setText('忘记密码？')->typeDanger()->plain()->href('/flexwire/h5/login/forgetPassword'))
            ->render();
    }

    public function forgetPassword()
    {
        return Content::make()
            ->title('忘记密码')
            ->block()
            ->add(new ForgetPasswordEmailForm())
            ->block()
//            ->row(Button::make()->setText('还没账号？去注册')->plain()->href('/flexwire/h5/register/emailRegister'))
            ->add(Button::make('返回-登录')->typeInfo()->plain()->href('/flexwire/h5/login/index'))
            ->render();
    }

    /**
     * 修改密码
     */
    public function resetPassword()
    {
        return Content::make()
            ->title('修改密码')
            ->block()
            ->add(new ResetPasswordForm())
            ->block()
//            ->row(Button::make()->setText('还没账号？去注册')->plain()->href('/flexwire/h5/register/emailRegister'))
            ->add(Button::make('返回-登录')->typeInfo()->plain()->href('/flexwire/h5/login/index'))
            ->render();
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/flexwire/h5/login/index');
    }
}

