<?php

namespace Liaosp\Flexwire\Component\Form;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\Component\ComponentAbstract;
use Liaosp\Flexwire\Layout\Content;

class FieldSwitch extends Field
{
    public function render()
    {
        $label = !empty($this->label) ? $this->label : $this->name ;

        return '<van-field  label="' . $label. '" placeholder="" >
<template #input>
    <van-switch v-model="' . $this->name . '" size="20" />
  </template>

</van-field>';
    }

}