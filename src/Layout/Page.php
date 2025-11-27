<?php

namespace Liaosp\Flexwire\Layout;

use Liaosp\Flexwire\Component\Form\FormBase;

class Page
{

    public $content = [];

    public function title()
    {

    }
    public function html(string $html)
    {
        $this->content[]  = [
            'type' => 'html',
            'value' => $html,
        ];
        return $this;
    }

    public function form(FormBase $form)
    {
        $this->content[]  = [
            'type' => 'form',
            'value' => $form,
        ];
        return $this;
    }

    public function render()
    {

    }
}