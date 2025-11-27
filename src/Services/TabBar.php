<?php

namespace Liaosp\Flexwire\Services;

use Illuminate\Support\Arr;
use Liaosp\Flexwire\Layout\Content;

class TabBar
{

    protected $tabBars;

    public function getTabBarData()
    {
        $this->tabBars[] = [
            'icon' => 'home-o',
            'name' => '首页',
            'url' => 'test'
        ];

        $this->tabBars[] = [
            'icon' => 'user-o',
            'name' => '个人中心',
            'url' => 'user'
        ];

        Content::addVueData(['tabBars' => $this->tabBars]);

        $result = Arr::first($this->tabBars, function ($item) {
            return strstr(request()->path(), $item['url']);
        });

        Content::addVueData(['tabBarActive' => $result['name'] ?? '']);
    }

    public function render()
    {
        $this->getTabBarData();
        return '
     <van-tabbar v-model="tabBarActive" >
        <van-tabbar-item :name="item.name" :url="item.url" :icon="item.icon" v-for="(item,index) in tabBars">{{item.name}}</van-tabbar-item>
    </van-tabbar>';
    }
}
