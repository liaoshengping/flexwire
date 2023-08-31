<?php

namespace Liaosp\Flexwire\layout;


use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Liaosp\Flexwire\Services\Async;
use Liaosp\Flexwire\Services\ToolService;

class Content implements Renderable
{

    /**
     * @var string
     */
    protected $view = 'flexwire::base';

    /**
     * content
     * @var
     */
    public $content;

    /**
     * title
     * @var string
     */
    protected $title;

    /**
     * 描述
     * @var
     */
    protected $description;

    /**
     * @var
     */
    protected $keywords;


    /**
     * @var
     */
    protected $rows;


    static $jsPrams = [];


    static $vueData = [];


    static $method = '';

    static $initJs = '';


    /**
     * Create a content instance.
     *
     * @param mixed ...$params
     */
    public static function make(...$params)
    {
        return new static(...$params);
    }

    public function body($content)
    {
        return $this->row($content);
    }


    public function render()
    {
        if (request()->expectsJson()) {
            return $this->jsonRender();
        }
        $html = '';
        foreach ($this->rows as $row) {
            $html .= $row->render();
        }
        $method = self::$method;
        $jsParams = self::$jsPrams;
        $initFunction = self::$initJs;

        foreach ($jsParams as $key => $value) {

            if (!empty($value['init'])) {
                $initFunction .= 'this.' . $value['function'] . '();' . PHP_EOL;
            }

            switch ($value['type']) {
                case 'alert':
                    $method .= $key . '(){
                this.$dialog.alert({
                    message: "' . $value['msg'] . '",
                    title:"' . $value['title'] . '"
                });
            },';
                    break;
                case 'toast':
                    $method .= $key . '(){
                this.$toast("' . $value['msg'] . '");
            },';
                    break;
                case 'asyncList':
                    $method .= view('flexwire::async-list-js', $value);
                    break;
            }
        }


        $vueData = '';
        foreach (self::$vueData as $key => $item) {

            if (is_string($item)) {
                $item = "'" . $item . "'";
            }

            if (empty($item) && is_array($item)) {
                $item = '[]';
            }
            if (is_array($item)) {
                $item = ToolService::format($item);
            }

            $vueData .= $key . ':' . $item . ',' . PHP_EOL;
        }


        return view($this->view, array_merge($value, [
            'content' => $html,
            'title' => $this->title,
            'method' => $method,
            'vueData' => $vueData,
            'init' => $initFunction,
        ]));
    }


    /**
     * @param string $title
     * @return Content
     */
    public function title(string $title): Content
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $description
     * @return Content
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }


    /**
     * @param mixed $keywords
     * @return Content
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * Add Row.
     *
     * @param Row $row
     */
    protected function addRow(Row $row)
    {
        $this->rows[] = $row;
    }


    /**
     * Add one row for content body.
     *
     * @param $content
     */
    public function row($content)
    {
        if ($content instanceof \Closure) {
            $row = new Row();
            call_user_func($content, $row);
            $this->addRow($row);
        } else {
            $this->addRow(new Row($content));
        }

        return $this;
    }


    public static function addVueData($array)
    {
        self::$vueData = array_merge(self::$vueData, $array);
    }

    public static function addJsParams($array)
    {
        self::$jsPrams = array_merge(self::$jsPrams, $array);
    }


    public function jsonRender()
    {
        $currentFunction = base64_decode(request()->input('currentFunction'));

        $service = Async::$register[$currentFunction];

        if ($service instanceof Model || $service instanceof \Illuminate\Database\Eloquent\Builder) {
            return $service->paginate();
        }


        return (new $currentFunction)->handle();
    }


    public static function addMethodString($method)
    {
        self::$method .= $method . PHP_EOL;
    }

    public static function addInitJs($js)
    {
        self::$initJs .= $js . PHP_EOL;
    }


}