<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\Layout\Content;

class Popup extends ComponentAbstract implements Renderable
{

    public $showName;

    public $methodName;


    public function __construct($content)
    {

        $this->setContent($content);

        $this->showName = 'popup' . rand(0, 999999999);

        $this->methodName = 'popupFunction' . $this->showName;

        Content::addVueData([
            $this->showName => false,
        ]);

        $method = '
            ' . $this->methodName . '(){
                console.log(this.' . $this->showName . ')
                this.' . $this->showName . ' = !this.' . $this->showName . '
                console.log("点击了")
            },
        ';

        Content::addMethodString($method);

    }

    public function render()
    {
//        :style="{ height: '30%' }"
        return '<van-popup position="top" closeable v-model="' . $this->showName . '" position="top"  >
' . $this->content . '
</van-popup>';
    }


    public function clickName()
    {
        return $this->methodName;
    }


}