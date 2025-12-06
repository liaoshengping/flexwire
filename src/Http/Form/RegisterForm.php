<?php

namespace Liaosp\Flexwire\Http\Form;

use Liaosp\Flexwire\Services\Form;
use Liaosp\Flexwire\Services\FormInterface;

class RegisterForm extends RegisterEmailForm implements FormInterface
{

    public function handle()
    {
        $validator = validator(
            request()->all(),
            [
                'email' => 'required|email',
                'code' => 'required|numeric',
                'password' => 'required|min:6'
            ],
            [
                'email.required' => '请输入邮箱',
                'email.email' => '请输入正确的邮箱',
                'code.required' => '请输入验证码',
                'code.numeric' => '验证码格式错误',
                'password.required' => '请输入密码',
                'password.min' => '密码长度不能小于6位'
            ]
        );
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        if (!cache($this->email . request()->input('code'))) {
            throw new \Exception('验证码错误，或已过期');
        }

        \App\Models\User::query()->create([
            'username' => $this->email,
            'name' => '用户',
            'password' => bcrypt(request()->input('password')),
        ]);


        return $this->success('注册成功', '/flexwire/h5/login/index');

    }

    public function form()
    {
        $this->textDisable('email', '邮箱');
        $this->text('code', '验证码');
        $this->text('password', '注册密码');
        $this->submit('注册');
    }


}
