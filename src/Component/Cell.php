<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;

/**
 * @doc https://vant-contrib.gitee.io/vant/v2/#/zh-CN/image
 */
class Cell extends ComponentAbstract implements Renderable
{


    protected $title;
    protected $value;
    protected $label;

    protected $values;

    public function __construct($title = '', $value = '')
    {
        if (is_array($title)) {
            $this->values = $title;
        }

        $this->title = $title;
        $this->value = $value;
    }

    public function render()
    {

        if (!$this->values) {
            return $this->buildCell($this->title, $this->value);
        }

        $cell = '';

        foreach ($this->values as $key => $value) {
            $cell .= $this->buildCell($key, $value);
        }

        return $cell;
    }


    public function buildCell($title, $value)
    {
        $cell = '<van-cell title="' . $title . '" value="' . $value . '" {{props}} ></van-cell>
';
        $temp = '';

        foreach ($this->props as $key => $value) {
            $temp .= $key . '=' . $value . ' ';
        }
        $cell = str_replace('{{props}}', $temp, $cell);

        return $cell;
    }



    /**
     * @param mixed $title
     * @return Cell
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $label
     * @return Cell
     */
    public function setLabel($label)
    {
        $this->props['label'] = $label;
        return $this;
    }

    /**
     * @param array $values
     * @return Cell
     */
    public function setValues(array $values): Cell
    {
        $this->values = $values;
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