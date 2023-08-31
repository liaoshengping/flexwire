<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\Widgets\Profiles\ShopItemCard;

class CardItem extends ComponentAbstract
{

    protected $tags;
    protected $bottom;
    protected $footer;


    public function render()
    {
        $render = ' <div style="margin-bottom: 10px"><van-card
  {{props}}
>
 {{tags}}
 {{footer}}
 {{bottom}}
</van-card></div>';

        if ($this->getPropsString()) {
            $render = str_replace('{{props}}', $this->getPropsString(), $render);
        }

        foreach (['tags','footer','bottom'] as $obj){
            $objString = '';
            if ($this->{$obj}) {
                if ($this->{$obj} instanceof Renderable) {
                    $objString = $this->{$obj}->render();
                } else {
                    $objString = $this->{$obj};
                }
                $render = str_replace('{{'.$obj.'}}', '
<template #'.$obj.'>
   '.$objString.'
</template>', $render);
            }
            $render = str_replace('{{'.$obj.'}}', $objString, $render);
        }
        return $render;
    }

    /**
     * @param mixed $tags
     * @return CardItem
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param mixed $bottom
     * @return CardItem
     */
    public function setBottom($bottom)
    {
        $this->bottom = $bottom;
        return $this;
    }

    /**
     * @param mixed $footer
     * @return CardItem
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * @param mixed $desc
     * @return CardItem
     */
    public function setDesc($desc)
    {
        $this->props['desc'] = $desc;
        return $this;
    }

    /**
     * @param mixed $thumb
     * @return CardItem
     */
    public function setThumb($thumb)
    {
        $this->props['thumb'] = $thumb;
        return $this;
    }

    public function setTitle($title)
    {
        $this->props['title'] = $title;
        return $this;

    }


    public function vueData()
    {
        // TODO: Implement vueData() method.
    }

    public function method()
    {
        // TODO: Implement method() method.
    }
}