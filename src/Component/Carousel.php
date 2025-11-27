<?php

namespace Liaosp\Flexwire\Component;

use Liaosp\Flexwire\Layout\Content;
use Liaosp\Flexwire\Services\Async;

class Carousel extends ComponentAbstract
{
    public $images = [];

    public function render()
    {
        Content::addVueData([
            'carousels' => $this->images,
        ]);

        return '<div style="height: 150px; text-align: center">
<van-swipe :autoplay="3000">
  <van-swipe-item v-for="(carousel, index) in carousels" :key="index">
    <van-image :src="carousel.image_url" /></van-image>
  </van-swipe-item>
</van-swipe>
</div>';
    }


    public function addImage($imageUrl, $imageJumpUrl = '')
    {
        $this->images[] = [
            'image_url' => $imageUrl,
            'image_jump_url' => $imageJumpUrl,
        ];

        return $this;
    }
}