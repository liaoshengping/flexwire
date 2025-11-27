<?php

namespace Liaosp\Flexwire\Component\Form;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\Component\ComponentAbstract;
use Liaosp\Flexwire\Layout\Content;

class Field extends ComponentAbstract implements Renderable
{

    protected $placeholder;


    protected $name = '';

    protected $label;


    public function __construct($name, $value = '')
    {
        Content::addVueData([$name => $value]);
        $this->name = $name;
    }


    public function render()
    {
        $label = !empty($this->label) ? $this->label : $this->name ;

        return '<van-field v-model="' . $this->name . '" label="' . $label. '" placeholder="" ></van-field>';
    }

    /**
     * @param mixed $placeholder
     * @return Field
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $label
     * @return Field
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }


}