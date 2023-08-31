<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\layout\Content;

class Button extends ComponentAbstract implements Renderable
{
    protected $text = "输入名称";
    protected $href = "";

    protected $jsParams = [];

    protected $id;


    public function __construct($text = '')
    {
        if ($text) {
            $this->text = $text;
        }
        $this->id = rand(0, 99999999999999999);
    }


    public function render()
    {
        $button = "<van-button @click='event$this->id()' type=\"primary\" {{props}}  >$this->text</van-button>";

        if ($this->href) {
            $button = "<a href='$this->href'>$button</a>";
        }

        $temp = '';

        foreach ($this->props as $key => $value) {
            $temp .= $key . '=' . $value . ' ';
        }
        $button = str_replace('{{props}}', $temp, $button);

        return $button;
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


    public function href($href)
    {
        $this->href = $href;
    }

    /**
     * @param string $href
     * @return Button
     */
    public function setHref(string $href): Button
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @param string $text
     * @return Button
     */
    public function setText(string $text): Button
    {
        $this->text = $text;
        return $this;
    }

    public function jsParams()
    {

        return $this->jsParams;

    }

    public function alert($title, $msg = '')
    {

        Content::$jsPrams['event' . $this->id] = [
            'type' => 'alert',
            'title' => $title,
            'msg' => $msg,
        ];


        return $this;
    }

    public function toast($msg = '')
    {

        Content::$jsPrams['event' . $this->id] = [
            'type' => 'toast',
            'msg' => $msg,
        ];

        return $this;
    }

    public function sizeMini()
    {
        $this->props['size'] = 'mini';
        return $this;
    }

    public function sizeSmall()
    {
        $this->props['size'] = 'small';
        return $this;

    }

    public function sizeNormal()
    {
        $this->props['size'] = 'normal';
        return $this;

    }

    public function sizeLarge()
    {
        $this->props['size'] = 'large';
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