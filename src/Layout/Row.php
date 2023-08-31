<?php

namespace Liaosp\Flexwire\layout;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\Services\ToolService;

/**
 * https://vant-contrib.gitee.io/vant/v2/#/zh-CN/col
 */
class Row implements Renderable
{
    protected $columns = [];

    protected $noGutters = false;

    /**
     * @var string
     */
    protected $type = 'flex';


    protected $flex = false;

    /**
     * @var string
     */
    protected $justify = 'center';

    /**
     * 其他底层返回的参数
     * @var
     */
    protected $jsParams = [];


    /**
     * Row constructor.
     *
     * @param string $content
     */
    public function __construct($content = '')
    {
        if (!empty($content)) {
            if ($content instanceof Column) {
                $this->addColumn($content);
            } else {
                $this->column(24, $content);
            }
        }
    }

    /**
     * Add a column.
     *
     * @param int $width
     * @param $content
     */
    public function column($width, $content)
    {

        $column = new Column($content, $width);

        $this->addColumn($column);
    }

    public function body($content)
    {
        $this->addColumn($content);
    }


    public function jsParams()
    {
        return $this->jsParams;
    }

    /**
     * @param $column
     */
    protected function addColumn($column)
    {
        $this->columns[] = $column;

    }

    /**
     * @param bool $value
     */
    public function noGutters(bool $value = true)
    {
        $this->noGutters = $value;

        return $this;
    }

    /**
     * Build row column.
     *
     * @return string
     */
    public function render()
    {
        $html = $this->startRow();

        foreach ($this->columns as $column) {
            $html .= ToolService::toolRender($column);
            if ($column instanceof Renderable && method_exists($column, 'jsParams')) {
                if ($column->jsParams()) {
                    $this->jsParams = array_merge($this->jsParams, $column->jsParams());
                }
            }
        }

        return $html . $this->endRow();
    }


    /**
     * Start row.
     *
     * @return string
     */
    protected function startRow()
    {
        $row = "
<van-row {{params}} >
";
        $replace = '';
        if ($this->flex) {
            $replace = "type='$this->type' justify='$this->justify'";
        }

        $row = str_replace("{{params}}", $replace, $row);

        return $row;
    }

    /**
     * End column.
     *
     * @return string
     */
    protected function endRow()
    {
        return '</van-row>
';
    }

    /**
     * @param string $justify
     */
    public function setJustify(string $justify)
    {
        $this->justify = $justify;
        return $this;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }


    public function justifyCenter(): Row
    {
        $this->flex = true;
        $this->justify = 'center';
        return $this;
    }

    public function justifyEnd(): Row
    {
        $this->flex = true;
        $this->justify = 'end';
        return $this;
    }

    public function justifyBetween(): Row
    {
        $this->flex = true;
        $this->justify = 'space-between';
        return $this;
    }

    public function justifyAround(): Row
    {
        $this->flex = true;
        $this->justify = 'around';
        return $this;
    }

    public function flex($bool = true)
    {
        $this->flex = $bool;
        return $this;
    }
}