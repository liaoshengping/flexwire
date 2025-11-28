<?php

namespace Liaosp\Flexwire\Services;

class Form
{




    public $content = [];


    public function success($msg='操作成功',$redirect = '')
    {
        return [
            'code' => 200,
            'msg' => $msg,
            'message' => $msg,
            'redirect' => $redirect,
        ];
    }

    public function fail($msg)
    {
        return [
            'code' => 500,
            'msg' => $msg,
            'message' => $msg,
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
    public function textDisable($filed, $name, $default = '')
    {
        $this->content[] = [
            'type' => 'textDisable',
            'filed' => $filed,
            'name' => $name,
            'default' => $default,
        ];
    }


    public function submit($name, $url = '',$color = 'primary')
    {
        $this->content[] = [
            'type' => 'submit',
            'name' => $name,
            'url' => $url,
            'color' => $color
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