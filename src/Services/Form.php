<?php

namespace Liaosp\Flexwire\Services;

class Form
{




    public $content = [];


    public function success($msg='操作成功')
    {
        return [
            'code' => 200,
            'msg' => $msg,
        ];
    }

    public function fail($msg)
    {
        return [
            'code' => 500,
            'msg' => $msg,
        ];
    }

    public function text($filed, $name, $default = '')
    {
        $this->content[] = [
            'type' => 'text',
            'filed' => $filed,
            'name' => $name,
            'default' => $default,
        ];
    }

    public function submit($name, $url = '')
    {
        $this->content[] = [
            'type' => 'submit',
            'name' => $name,
            'url' => $url,
        ];
    }

    /**
     * @return array
     */
    public function data(){return [];}

    public function confirm()
    {
        return '';
    }

    public function render()
    {
        $this->form();
        return [
            'class' => (new ToolService())->encode(get_class($this)),
            'class_name' => basename(str_replace('\\', '/', __CLASS__)),
            'form' => $this->content,
            'confirm' => $this->confirm(),
        ];
    }

}