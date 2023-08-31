<?php

namespace Liaosp\Flexwire\Widgets\Profiles;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\Component\Cell;
use Liaosp\Flexwire\Component\Image;
use Liaosp\Flexwire\Layout\Column;
use Liaosp\Flexwire\Layout\Row;
use Liaosp\Flexwire\Widgets\WidgetAbstract;

class ShopItemCard extends WidgetAbstract implements Renderable
{

    protected $tags;

    protected $bottom;

    protected $footer;

    protected $title;

    protected $desc;

    protected $thumb;


    public function render()
    {
        $render = '<van-card
  desc="描述信息"
  title="商品标题"
  thumb="https://img01.yzcdn.cn/vant/ipad.jpeg"
>
  <template #tags>
    <van-tag plain type="danger">标签</van-tag>
    <van-tag plain type="danger">标签</van-tag>
  </template>
  <template #footer>
    <van-button size="mini">按钮</van-button>
  </template>

  <template #bottom>
    <div>地址：厦门市湖里区远东路112号</div>
    <div>地址：厦门市湖里区远东路112号</div>
  </template>
</van-card>';

        if ($this->getPropsString())

        return $render;
    }



}