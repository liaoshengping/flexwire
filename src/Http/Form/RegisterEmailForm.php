<?php

namespace Liaosp\Flexwire\Http\Form;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Liaosp\Flexwire\Services\Form;
use Liaosp\Flexwire\Services\FormInterface;

class RegisterEmailForm extends Form implements FormInterface
{
    protected string $email;

    public function __construct()
    {
        $this->email = request()->input('email','');
    }

    public function handle()
    {
        $validator = validator([
            'email' => $this->email],
            ['email' => 'required|email'],
            [
                'email.required' => '请输入邮箱',
                'email.email' => '请输入正确的邮箱',
            ]
        );
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        $code = rand(1000,9999);
        $text = <<<TEXT
{$code}
TEXT;

        //发送邮箱
        Mail::raw($text,function ($message){
            $message->to('1194008361@qq.com')->subject('验证码');
        });

        Cache::put($this->email.$code,true,'300');//5分钟激活码

        return $this->success('发送成功','/h5/register/emailRegister?email='.$this->email);
    }

    public function form()
    {
        $this->text('email','输入邮箱');
        $this->submit('获取验证码');
    }

    public function data()
    {

        return ['email' => $this->email];
    }
}
