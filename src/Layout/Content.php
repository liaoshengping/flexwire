<?php

namespace Liaosp\Flexwire\Layout;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Liaosp\Flexwire\Services\Async;
use Liaosp\Flexwire\Services\Form;
use Liaosp\Flexwire\Services\TabBar;
use Liaosp\Flexwire\Services\ToolService;

class Content implements Renderable
{


    public static $tabBar;

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


    public static $jsPrams = [];


    public static $vueData = [];


    public static $method = '';

    public static $initJs = '';

    public static $endContent = '';

    protected $showTabBar = false;

    protected $backgroupColor = 'gray';


    protected $attributeData = [];


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

    public function add($content)
    {
        $this->rows[] = $content;
        return $this;
    }


    public function render()
    {
        if (request()->expectsJson()) {
            return $this->jsonRender();
        }

        $tabBar = '';
        if ($this->showTabBar) {
            $tabBar = !empty(self::$tabBar) ? self::$tabBar->render() : (new TabBar())->render();
        }
//        <van-swipe :autoplay="3000">
//  <van-swipe-item v-for="(image, index) in images" :key="index">
//    <img v-lazy="image" />
//  </van-swipe-item>
//</van-swipe>
        $html = '';
        foreach ($this->rows as $row) {

            $rowType = '';
            if (is_array($row)) {
                $rowType = $row['type'] ?? '';
            }

            switch ($rowType) {
                case 'block':
                    $html .= '<br>';
                    break;
                case 'banner':
                    $swipeItem = '';
                    foreach ($row['images'] as $itemImage){
                        $swipeItem.=' <van-swipe-item><image height="100%" width="100%"
  src="'.$itemImage.'"
/></van-swipe-item>';
                    }

                    $html .= '<van-swipe style="height: 200px;" :autoplay="3000">
  '.$swipeItem.'
</van-swipe>';
                    break;
            }

            if ($row instanceof Form) {
                /**
                 * @var Form $row
                 */
                $formResult = $row->render();
                if ($row->content) {
                    foreach ($row->content as $item) {
                        $formData = $row->data();
                        self::addVueData([$formResult['class_name'] . '_confirm' => $formResult['confirm']]);
                        if (empty($item['type'])) continue;
                        switch ($item['type']) {
                            case 'text':
                                if (empty($item['filed'])) continue 2;
                                $html .= '
                                <van-field v-model="' . $item['filed'] . '" label="' . $item['name'] . '" placeholder="请输入" /></van-field>';
                                $formThisDataValue = Arr::get($formData, $item['filed'],'');
                                self::addVueData([$item['filed'] => $formThisDataValue]);
                                break;

                            case 'textDisable':
                                if (empty($item['filed'])) continue 2;
                                $html .= '
                                <van-field disabled v-model="' . $item['filed'] . '" label="' . $item['name'] . '" placeholder="请输入" /></van-field>';
                                $formThisDataValue = Arr::get($formData, $item['filed'],'');
                                self::addVueData([$item['filed'] => $formThisDataValue]);
                                break;
                            case 'submit':
                                $htmlName = $item["name"];
                                $functionFullName = $formResult['class_name'] . "('" . $formResult["class"] . "')";
                                $functionName = $formResult['class_name'];
                                $functionNameConfirm = $formResult['class_name'] . '_confirm';
                                $confirm = $formResult['confirm'];
                                $color = $item['color'];
                                $html .= <<<HTML

<van-button @click="$functionFullName" style="margin-top: 20px" size="large" type = "$color"  type="primary">$htmlName</van-button>
HTML;
                                $dialog = '$dialog';
                                $showLoading = '$showLoading';
                                $toast = '$toast';
                                self::$method .= <<<TEXT
{$functionName}(class_name) {
const postData = {
                class_name: class_name,
            };

      allData = this.getData();
      newData = {...postData,...allData}
      that = this

            this.$toast.loading({
  message: '加载中...',
  forbidClick: true,
});




            // 使用 Axios 发送 POST 请求
            if(this.$functionNameConfirm){

             that.$dialog.confirm({
                    title: '提示',
                    message: "$confirm",
                }).then(() => {
                 axios.post('/flexwire/get-service2', newData, {
    withCredentials: true
})
                .then(function (response) {
                   that.$toast.clear();
                    if (response.data.message){
                       that.$toast(response.data.message)
                       if (response.data.redirect){
                            setTimeout(function () {
                                window.location.href = response.data.redirect;
                            }, 1000);
                       }
                    }

                })
                .catch(function (error) {
                    // 请求失败时执行的代码
                    console.error('Error:', error);
                });
                });
            }else{
                axios.post('/flexwire/get-service2', newData, {
    withCredentials: true
})
                .then(function (response) {
                    that.$toast.clear();
                    if (response.data.message){
                       that.$toast(response.data.message)
                       if (response.data.redirect){
                            setTimeout(function () {
                                window.location.href = response.data.redirect;
                            }, 1000);
                       }
                    }
                })
                .catch(function (error) {
                    // 请求失败时执行的代码
                    console.error('Error:', error);

                });

            }


},
TEXT;

                                break;
                        }

                    }
                }

            } else {

                if (is_object($row) && method_exists($row, 'render')) {
                    $html .= $row->render();
                }

            }
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

            if ($item === false) {
                $item = 'false';
            }

            if ($item === true) {
                $item = 'true';
            }


            $vueData .= $key . ':' . $item . ',' . PHP_EOL;
        }


        $withData = array_merge($value ?? [], [
            'content' => $html,
            'title' => $this->title,
            'method' => $method,
            'vueData' => $vueData,
            'init' => $initFunction,
            'endContent' => self::$endContent,
            'tabBar' => $tabBar,
        ]);


        return view($this->view, array_merge($withData, $this->attributeData));
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

    public function block($height = 15)
    {
        $this->rows[] = [
            'type' => 'block',
            'height' => $height
        ];
        return $this;
    }

    public function banner($images)
    {
        $this->rows[] = [
            'type' => 'banner',
            'images' => $images
        ];
        return $this;
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
            $row = new Row($content);
            $this->addRow($row);
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

    public static function addEndContent($content)
    {
        self::$endContent .= $content;
    }


    public function disableShowTabBar()
    {
        $this->showTabBar = false;
        return $this;

    }

    public function showTabBar()
    {
        $this->showTabBar = true;

        return $this;
    }

    /**
     * @param string $backgroupColor
     * @return Content
     */
    public function setBackgroupColor(string $backgroupColor): Content
    {
        $this->attributeData['backgroup_color'] = $backgroupColor;

        return $this;
    }


}
