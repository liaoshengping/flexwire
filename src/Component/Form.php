<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;

class Form extends ComponentAbstract implements Renderable
{

    protected $field;

    public function render()
    {

    }

    /**
     * @param mixed $field
     * @return Form
     */
    public function add($field)
    {

        if ($field instanceof Renderable) {
            $this->field[] = [
                'field' => $field->render()
            ];
            return $this;
        }


        $this->field[] = [
            'field' => $field
        ];
        return $this;
    }


}