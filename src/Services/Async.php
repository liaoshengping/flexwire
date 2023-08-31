<?php

namespace Liaosp\Flexwire\Services;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\layout\Content;

class Async implements Renderable
{
    /**
     * 方法是否进行初始化，还是后续动作触发
     * @var bool
     */
    protected $init = true;

    public $dataKeyName = '';

    protected $template;

    static $register;

    protected $requestParams;

    protected $showType = self::SHOW_TYPE_SHOW;

    protected $pageStyle = self::PAGE_STYLE_LIST;

    const SHOW_TYPE_SHOW = 'show';
    const SHOW_TYPE_PAGE = 'page';

    const PAGE_STYLE_LIST = 'list'; //下拉加载
    const PAGE_STYLE_PAGE = 'page'; //分页


    public function __construct($abstract)
    {


        $objClass = get_class($abstract);
        $getDataKey = $this->getDataKey($abstract);
        $i = $getDataKey['i'];
        $keyData = $getDataKey['keyData'] . $i;


        $this->dataKeyName = $keyData;

        if (method_exists($abstract, 'data')) {
            Content::addVueData($abstract->data());
        }
        Content::addVueData([
            $this->dataKeyName . '_DATA' => [],
            $this->dataKeyName . '_CLASS' => base64_encode($objClass),
            $this->dataKeyName . '_FIRSTLOADING' => true,
            $this->dataKeyName . '_PAGE' => 1,
            $this->dataKeyName . '_LOADING' => 0,
            $this->dataKeyName . '_LOADINGFINISH' => 0,
        ]);

        Content::$jsPrams[$this->dataKeyName] = [
            'type' => 'asyncList',
            'data' => $keyData . '_DATA',
            'url' => base64_encode($objClass),
            'key' => $keyData,
            'class' => base64_encode($objClass . $i),
            'function' => $keyData . '_FUNCTION',
            'loading' => $keyData . '_FIRSTLOADING',
            'listLoading' => $keyData . '_LOADING',
            'listLoadingFinish' => $keyData . '_LOADINGFINISH',

        ];


    }


    public function getDataKey($abstract, $i = 0)
    {

        if (!empty(self::$register[get_class($abstract) . $i])) {
            return $this->getDataKey($abstract, $i + 1);
        }

        self::$register[get_class($abstract) . $i] = $abstract;

        $objClass = get_class($abstract);
        $keyData = ToolService::convertToAlphabetic($objClass);

        return compact('keyData', 'i');
    }

    public function render()
    {
        Content::$jsPrams[$this->dataKeyName]['init'] = $this->init;
        //判断是否分页
        $this->requestParams('page', $this->dataKeyName . '_PAGE');
        $this->requestParams('pageSize');

        Content::$jsPrams[$this->dataKeyName]['requestParams'] = $this->requestParams;


        $content = $this->template;

        if ($content instanceof Renderable) {
            $content = $content->render();
        }

        $dataKey = $this->dataKeyName . '_DATA';
        $firstLoading = $this->dataKeyName . '_FIRSTLOADING';
        $pageFunctionName = $this->dataKeyName . '_PAGEFUNCTION';
        $loadingFinish = $this->dataKeyName . '_LOADINGFINISH';
        $pageName = $this->dataKeyName . '_PAGE';
        $function = $this->dataKeyName . '_FUNCTION';
        $loading = $this->dataKeyName . '_LOADING';

        $html = "
<van-skeleton title round   :row=10 :loading='$firstLoading' >

<div  v-for= 'item in $dataKey.data' >
            $content
</div>

  {{page}}


</van-skeleton>
";
        $pageReplace = '';

        if ($this->showType == self::SHOW_TYPE_PAGE) {
            $pageReplace = "<van-pagination v-model='$pageName' @change='$pageFunctionName'  :page-count='$dataKey.last_page'  ></van-pagination>";
        }

        $html = str_replace('{{page}}', $pageReplace, $html);

        if ($this->pageStyle == self::PAGE_STYLE_LIST) {
            $html = "
            <van-list
              :finished='$loadingFinish'
              v-model='$loading'
              finished-text='没有更多了'
              @load='$function'
            >
                <div  v-for= 'item in $dataKey' >
                            $content
                </div>
            </van-list>
";
        }

        $this->pageFunction();

        return $html;
    }

    public function setTemplate($content)
    {

        $this->template = $content;

        return $this;
    }


    public static function each($abstract)
    {
        $obj = new static($abstract);
        //获取链接
        return $obj;

    }

    public static function page($abstract)
    {
        $obj = new static($abstract);
        $obj->showType = self::SHOW_TYPE_PAGE;
        //获取链接
        return $obj;

    }


    public static function show($abstract)
    {
        return new static($abstract);
    }


    public function disableInit()
    {
        $this->init = false;

        return $this;
    }

    public function requestParams($key, $value = '')
    {

        if (empty($value)) {
            $this->requestParams .= "requestData.$key = thisData.$key;
        ";

        } else {
            $this->requestParams .= "requestData.$key = thisData.$value;
        ";
        }


        return $this;

    }

    private function pageFunction()
    {
        $functionName = $this->dataKeyName . '_PAGEFUNCTION';
        $reloadFunction = $this->dataKeyName . '_FUNCTION';
        $page = $this->dataKeyName . '_PAGE';
        Content::addMethodString("
                $functionName(page){
                    this.$page =page
                    this.$reloadFunction()
                },
        ");


    }


}