<?php

namespace Liaosp\Flexwire\Http\Controllers;

use App\H5\Form\LoginForm;
use Liaosp\Flexwire\Component\Button;
use Liaosp\Flexwire\Layout\Column;
use Liaosp\Flexwire\Layout\Content;
use Liaosp\Flexwire\Layout\Row;

class Login
{
    public function index()
    {
        return Content::make()
            ->title('登录')
            ->block()
            ->add(new LoginForm())
            ->block()
            ->row(Button::make()->setText('还没账号？去注册')->plain()->href('/h5/register/emailRegister'))
            ->render();
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/h5/login/index');
    }
}

