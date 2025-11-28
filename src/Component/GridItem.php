<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;

class GridItem extends ComponentAbstract implements Renderable
{
    public $text = '文本';
    public $icon = 'bag-o';
    public $url = '';

    public function __construct($text = '文本',$url = '',$icon = 'bag-o' )
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->url = $url;
    }

    public function render()
    {
        $html = <<<HTML
<van-grid-item icon="$this->icon" text="$this->text" url="$this->url" > </van-grid-item>
HTML;
        return $html;
    }

    public function setText(string $text): GridItem
    {
        $this->text = $text;
        return $this;
    }
}