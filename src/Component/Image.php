<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;

/**
 * @doc https://vant-contrib.gitee.io/vant/v2/#/zh-CN/image
 */
class Image implements Renderable
{

    protected $url = '';

    protected $width = '4em';

    protected $height = '4em';

    protected $props = [];


    public function __construct($url = '')
    {
        $this->url = $url;
    }

    public function render()
    {
        $image = '<van-image
  width="' . $this->width . '"
  height="' . $this->height . '"
  {{props}}
  src="' . $this->url . '"
></van-image>';
        $temp = '';

        foreach ($this->props as $key => $value) {
            $temp.=$key.'='.$value.' ';
        }


        $image = str_replace('{{props}}',$temp, $image);

        return $image;
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

    /**
     * @param string $url
     * @return Image
     */
    public function setUrl(string $url): Image
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param string $height
     * @return Image
     */
    public function setHeight(string $height): Image
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @param string $width
     * @return Image
     */
    public function setWidth(string $width): Image
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @param array $props
     * @return Image
     */
    public function setProps(array $props): Image
    {
        $this->props = array_merge($this->props, $props);
        return $this;
    }

    public function round()
    {
        $this->props['round'] = true;
        return $this;
    }


}