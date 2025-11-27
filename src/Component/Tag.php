<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;

class Tag extends ComponentAbstract implements Renderable
{

    protected $text = '按钮';

    protected $type = 'primary';

    public function __construct($text = '')
    {
        $this->text = $text;
    }

    public function render()
    {
        return "<van-tag style='margin-right:3px' type='$this->type'>$this->text</van-tag>";
    }

    public function typePrimary()
    {
        $this->type = 'primary';

        return $this;
    }

    public function typeSuccess()
    {
        $this->type = 'success';
        return $this;

    }

    public function typeDanger()
    {
        $this->type = 'danger';
        return $this;

    }

    public function typeWarning()
    {
        $this->type = 'warning';
        return $this;

    }

}