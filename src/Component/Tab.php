<?php

namespace Liaosp\Flexwire\Component;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;
use Liaosp\Flexwire\Layout\Content;
use Liaosp\Flexwire\Services\Async;
use Liaosp\Flexwire\Services\ToolService;

class Tab extends ComponentAbstract implements Renderable
{

    protected $tabs = [];

    protected $tableRelationAsync = [];

    protected $activeName = 'activeName';

    public function render()
    {
        if (empty($this->tabs)) {
            return '';
        }

        Content::addVueData([
            $this->activeName => $this->tabs[0]['title'],
            'tableRelationAsync' => $this->tableRelationAsync,
        ]);


        $html = <<<HTML
<van-tabs v-model="$this->activeName" @click="tabClick" >
 {{tab}}
</van-tabs>
HTML;

        $string = '';

        foreach ($this->tabs as $value) {
            $string .= ' <van-tab  title="' . $value['title'] . '" name="' . $value['title'] . '" >' . $value['content'] . '</van-tab>' . PHP_EOL;
        }

        $html = str_replace('{{tab}}', $string, $html);


        return $html;

    }

    public function add($title, $content)
    {
        $async = false;
        $dataKeyName = '';

        if ($content instanceof Renderable) {


            if ($content instanceof Async) {
                $async = true;
            }

            if (property_exists($content, 'dataKeyName')) {

                $dataKeyName = $content->dataKeyName;
            }

            $content = $content->render();

        }


        $temp = [
            'title' => $title,
            'content' => $content,
            'is_sync' => $async,
            'sync_service_key' => $dataKeyName,
        ];

        $this->tabs = array_merge($this->tabs, [$temp]);

        unset($temp['content']);
        $this->tableRelationAsync[$title] = $temp;


        return $this;
    }


    public function method()
    {
        return '
        tabClick(name, title){
                let keyData = this.tableRelationAsync[name];
                if(keyData && keyData.is_sync){
                 let data = this[keyData.sync_service_key+"_DATA"];
                 if(isEmpty(data)){
                 this[keyData.sync_service_key+"_FUNCTION"]()
                 }
                }
            },
           checkFirstTab(){
                let keyData = this.tableRelationAsync[this.'.$this->activeName.'];
                if(keyData && keyData.is_sync){
                 let data = this[keyData.sync_service_key+"_DATA"];
                 if(isEmpty(data)){
                 this[keyData.sync_service_key+"_FUNCTION"]()
                 }
                }
            },

            ';


    }

    public function initJs(){
        return '
            this.checkFirstTab();
        ';
    }
}