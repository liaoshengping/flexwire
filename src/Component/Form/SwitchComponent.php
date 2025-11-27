<?php

namespace Liaosp\Flexwire\Component\Form;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\Component\ComponentAbstract;

class SwitchComponent extends ComponentAbstract implements Renderable
{

    public function render()
    {
        return '<van-switch v-model="checked" ></van-switch>';
    }
}