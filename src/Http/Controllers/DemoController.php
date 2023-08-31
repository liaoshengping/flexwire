<?php

namespace Liaosp\Flexwire\Http\Controllers;

use App\ApiService\FirstApiService;
use App\Models\Merchant;
use App\Models\QwMember;
use App\Models\User;
use Liaosp\Flexwire\Component\Button;
use Liaosp\Flexwire\Component\Card;
use Liaosp\Flexwire\Component\CardItem;
use Liaosp\Flexwire\Component\Tab;
use Liaosp\Flexwire\layout\Column;
use Liaosp\Flexwire\layout\Content;
use Liaosp\Flexwire\layout\Row;
use Liaosp\Flexwire\Services\Async;
use Liaosp\Flexwire\Widgets\Profiles\ProfileSimple;

class DemoController
{
    public function index()
    {

        return Content::make()
            ->title('测试第一个页面')
            ->row(function (Row $row) {
                $row->column(24, function (Column $column) {
                    $column->row(function (Row $row) {
                        $card = Card::make('用户信息', ProfileSimple::make()
                            ->setUsername('奔跑')
                            ->setContents([
                                'openid' => '9564312a54sd3fsd',
                                '首单时间' => '2022-12-15 17:56:54',
                            ]));
                        $row->column(0, $card);
                    });
                });

                $button = Button::make()
                    ->setText('售后')
                    ->sizeMini()
                    ->alert('你点击了申请售后')
                    ->render();

                //data 肯定是一个数组
                $async = Async::page(QwMember::query())
                    ->disableInit()
                    ->setTemplate(CardItem::make()
                        ->setTitle('item.name')
                        ->setDesc('item.desc')
                        ->setThumb('item.ext_data.external_contact.avatar')
                        ->setTags('<van-tag>已完成</van-tag>')
                        ->setBottom('
                        <div>{{item.name}}</div>
                        <div>订单号：1231899128739816</div>
                        <div>收货地址：厦门市湖里区</div>
                        <div>邮政编码：646468484578</div>
                    ')->setFooter($button));

                $asyncRefund = Async::each(Merchant::query())
                    ->disableInit()
                    ->setTemplate(CardItem::make()
                        ->setTitle('item.name')
                        ->setDesc('item.desc')
                        ->setThumb('http://wx.qlogo.cn/mmhead/Q3auHgzwzM7XJ3q16a3Op4ncyXPAXQBFnSyMvPTgyLq2R3YtmlbXYQ/0')
                        ->setTags('<van-tag>已售后</van-tag>')
                        ->setBottom('
                        <div>{{item.name}}</div>
                        <div>订单号：1231899128739816</div>
                        <div>收货地址：厦门市湖里区</div>
                        <div>邮政编码：646468484578</div>
                    ')->setFooter($button));

                $tab = Tab::make()->add('订单列表', $async);
                $tab->add('售后订单', $asyncRefund);
//                $tab->add('回访记录', $async);

                $row->body(Card::make()->setTitle('订单信息')->setContent($tab));

            })
            ->render();
    }

    public function async()
    {
        return Content::make()
            ->title('同步列表')
            ->row(function (Row $row){
                $button = Button::make()
                    ->setText('售后')
                    ->sizeMini()
                    ->alert('你点击了申请售后')
                    ->render();

                //data 肯定是一个数组
                $async = Async::page(QwMember::query())
                    ->disableInit()
                    ->setTemplate(CardItem::make()
                        ->setTitle('item.name')
                        ->setDesc('item.desc')
                        ->setThumb('item.ext_data.external_contact.avatar')
                        ->setTags('<van-tag>已完成</van-tag>')
                        ->setBottom('
                        <div>{{item.name}}</div>
                        <div>订单号：1231899128739816</div>
                        <div>收货地址：厦门市湖里区</div>
                        <div>邮政编码：646468484578</div>
                    ')->setFooter($button));

                $asyncRefund = Async::each(Merchant::query())
                    ->disableInit()
                    ->setTemplate(CardItem::make()
                        ->setTitle('item.name')
                        ->setDesc('item.desc')
                        ->setThumb('http://wx.qlogo.cn/mmhead/Q3auHgzwzM7XJ3q16a3Op4ncyXPAXQBFnSyMvPTgyLq2R3YtmlbXYQ/0')
                        ->setTags('<van-tag>已售后</van-tag>')
                        ->setBottom('
                        <div>{{item.name}}</div>
                        <div>订单号：1231899128739816</div>
                        <div>收货地址：厦门市湖里区</div>
                        <div>邮政编码：646468484578</div>
                    ')->setFooter($button));

                $tab = Tab::make()->add('订单列表', $async);
                $tab->add('售后订单', $asyncRefund);
                $row->body($tab);
            })->render();
    }
}