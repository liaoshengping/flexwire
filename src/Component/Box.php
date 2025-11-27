<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;

class Box extends ComponentAbstract implements Renderable
{

    protected $margin = 'margin:10px';


    public function __construct($content)
    {
        if ($content instanceof Renderable) {
            $content = $content->render();
        }

        $this->content = $content;
    }

    public function marginTopAndBottom()
    {
        $this->margin = 'margin: 10px 0 ';

        return $this;
    }

    public function render()
    {
        $html = "<div style='{{margin}}'>$this->content</div>";

        $html = str_replace('{{margin}}', $this->margin, $html);

        return $html;

    }



}