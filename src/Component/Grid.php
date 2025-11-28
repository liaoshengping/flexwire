<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;

class Grid extends ComponentAbstract implements Renderable
{
    public $column_num = 3;
    public $itemsHtml = '';

    public function __construct($items = [],$column_num = 3)
    {
        $this->column_num = $column_num;

        foreach ($items as $item) {
            $this->itemsHtml .= $item->render();
        }
    }

    public function render()
    {
        $html = <<<HTML
<van-grid clickable :column-num="$this->column_num">
$this->itemsHtml
</van-grid>
HTML;
        return $html;
    }
}