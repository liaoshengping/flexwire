<?php

namespace Liaosp\Flexwire\Http\Controllers;

use App\Http\Controllers\Mobile\Form\AddTestIp;
use Liaosp\Flexwire\Http\Form\CodeValidateForm;
use Liaosp\Flexwire\Layout\Content;
use Liaosp\Flexwire\Layout\Page;

class FormController
{
    public function resetCode()
    {
        $content = Content::make()
            ->title('激活码')
            ->banner(['https://s21.ax1x.com/2024/12/31/pAz12M4.png'])
            ->block()
            ->add(new CodeValidateForm());
        return $content->render();
    }

    public function addTestIp()
    {
        $content = Content::make()
            ->title('添加测试IP')
            ->banner(['https://s21.ax1x.com/2024/12/31/pAz12M4.png'])
            ->block()
            ->add(new AddTestIp());
        return $content->render();
    }
}