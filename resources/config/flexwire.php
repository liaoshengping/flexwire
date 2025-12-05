<?php

return [
    'middleware' => ['web','flexwire.auth'],

    // 不验证接口的form交互
    'not_auth_class' => [
        \Liaosp\Flexwire\Http\Form\LoginForm::class,
        \Liaosp\Flexwire\Http\Form\RegisterForm::class,
        \Liaosp\Flexwire\Http\Form\RegisterEmailForm::class,
        \Liaosp\Flexwire\Http\Form\ForgetPasswordEmailForm::class,
        \Liaosp\Flexwire\Http\Form\ResetPasswordForm::class
    ],
    'middleware_class' => \Liaosp\Flexwire\Http\Middleware\H5Auth::class
];
