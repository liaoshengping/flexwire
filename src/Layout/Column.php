<?php

namespace Liaosp\Flexwire\layout;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\Services\ToolService;

/**
 * https://vant-contrib.gitee.io/vant/v2/#/zh-CN/col
 */
class Column implements Renderable
{
    /**
     * grid system prefix width.
     *
     * @var array
     */
    protected $width = [];

    /**
     * @var array
     */
    protected $contents = [];


    protected $jsParams = [];

    protected $widthFull;

    protected $textAlign;


    /**
     * Column constructor.
     *
     * @param $content
     * @param int $width
     */
    public function __construct($content, $width = 12)
    {
        $width = $this->normalizeWidth($width);

        if ($content instanceof \Closure) {
            call_user_func($content, $this);
        } else {
            $this->append($content);
        }

        $this->width = $width;
    }

    protected function normalizeWidth($width)
    {
        return (int)($width < 1 ? round(12 * $width) : $width);
    }

    /**
     * Append content to column.
     *
     * @param $content
     */
    public function append($content)
    {
        $this->contents[] = $content;

        if ($content instanceof Renderable && method_exists($content, 'jsParams')) {
            if ($content->jsParams()) {
                $this->jsParams = array_merge($this->jsParams, $content->jsParams());
            }
        }

        return $this;
    }

    public function add($content)
    {
        return $this->append($content);
    }

    /**
     * Add a row for column.
     *
     * @param $content
     * @return Column
     */
    public function row($content)
    {
        if (!$content instanceof \Closure) {
            $row = new Row($content);
        } else {
            $row = new Row();
            call_user_func($content, $row);
        }

        $this->append($row);

        return $this;
    }


    public function body($content)
    {
        return $this->append($content);
    }

    /**
     * Build column html.
     *
     * @return string
     */
    public function render()
    {
        $html = $this->startColumn();

        foreach ($this->contents as $content) {
            $html .= ToolService::toolRender($content);
            if ($content instanceof Renderable && method_exists($content, 'jsParams')) {
                if ($content->jsParams()) {
                    $this->jsParams = array_merge($this->jsParams, $content->jsParams());
                }
            }
        }

        return $html . $this->endColumn();
    }


    /**
     * Start column.
     *
     * @return string
     */
    protected function startColumn()
    {
//        // get class name using width array
//        $classnName = collect($this->width)->map(function ($value, $key) {
//            return $value == 0 ? "col-$key" : "col-$key-$value";
//        })->implode(' ');
//        var_dump($this->width);exit;
        if ($this->width == 0) {
            $div = "<div style='{{style}}'>
";

            $style = '';

            if ($this->textAlign) {
                $style .= 'text-align:' . $this->textAlign . ';';
            }

            if ($this->widthFull) {
                $style .= ' width:' . $this->widthFull . ';';
            }

            $div = str_replace('{{style}}', $style, $div);

            return $div;
        }
        return "<van-col span='$this->width' >
";
    }


    public function jsParams()
    {
        return $this->jsParams;
    }

    /**
     * End column.
     *
     * @return string
     */
    protected function endColumn()
    {
        if ($this->width == 0) {
            return '
    </div>
';
        }

        return '
    </van-col>
';
    }

    public function textAlignCenter()
    {
        return $this->textAlign = 'center';
    }

    public function widthFull()
    {
        return $this->widthFull = '100%';
    }


}