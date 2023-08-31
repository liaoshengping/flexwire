<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\layout\Content;

abstract class ComponentAbstract implements Renderable
{

    public function __construct()
    {
        if (method_exists($this,'method')){
            Content::addMethodString($this->method()??'');
        }

        if (method_exists($this,'initJs')){
            Content::addInitJs($this->initJs()??'');
        }


    }

    protected $content = "";

    protected $props = [];


    public function method(){

    }

    public function initJs(){

    }



    /**
     * @param  $content
     */
    public function setContent($content)
    {
        if ($content instanceof Renderable) {
            $content = $content->render();
        }

        $this->content = $content;
        return $this;
    }

    /**
     * @param array $props
     * @return ComponentAbstract
     */
    public function setProps(array $props): ComponentAbstract
    {
        $this->props = array_merge($this->props, $props);

        return $this;
    }

    public function getPropsString(): string
    {
        $temp = '';

        foreach ($this->props as $key => $value) {

            if (strstr($value, 'item.')) {
                $key = ':' . $key;
            }

            $temp .= $key . "= '" . $value . "'";
        }

        return $temp;
    }

    /**
     * Create a content instance.
     *
     * @param mixed ...$params
     */
    public static function make(...$params)
    {
        return new static(...$params);
    }


}