<?php

namespace Liaosp\Flexwire\Http\Controllers;

use Liaosp\Flexwire\Component\Grid;
use Liaosp\Flexwire\Component\GridItem;
use Liaosp\Flexwire\Layout\Content;

class Home
{
    public function index()
    {
        $content = Content::make()
            ->body(Grid::make([
                GridItem::make('功能1'),
                GridItem::make('退出2','/flexwire/h5/login/logout','close'),
            ],2));
        $content->render();
        return $content;
    }
}
