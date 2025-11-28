<?php

return [
    'middleware' => ['web','h5.auth'],

    // 不验证接口的form交互
    'not_auth_class' => [
        \Liaosp\Flexwire\Http\Form\LoginForm::class,
        \Liaosp\Flexwire\Http\Form\RegisterForm::class,
    ]
];
