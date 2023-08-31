<?php

namespace Liaosp\Flexwire\Component;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;

class Card extends ComponentAbstract implements Renderable
{
    const TITLE_MODEL_INSIDE = 'inside';

    protected $title = "";

    protected $titleMode = self::TITLE_MODEL_INSIDE;

    /**
     * @var string
     */
    protected $cardStyle = 'margin: 10px;background-color: white;padding: 10px;border-radius: 10px';


    public function __construct($title = '', $content = null)
    {
        if ($content === null) {
            $title = '';
        }

        $this->setTitle($title);
        $this->setContent($content);

    }

    public function render()
    {
        $card = '';

        if ($this->titleMode == self::TITLE_MODEL_INSIDE) {
            $card .= "<div class='van-row' style='width: 100%;padding-left:10px;margin-top:10px;color: rgba(69, 90, 100, 0.6)'>$this->title</div>";
        }

        $card .= "<div class='van-row' style='$this->cardStyle'>$this->content</div>";

        return $card;
    }

    /**
     * Create a content instance.
     *
     * @param mixed ...$params
     */
    public static function make(...$params)
    {
        return new static(...$params);
    }

    /**
     * @param string $title
     * @return Card
     */
    public function setTitle(string $title): Card
    {
        $this->title = $title;
        return $this;
    }


    /**
     * @param string $cardStyle
     * @return Card
     */
    public function setCardStyle(string $cardStyle): Card
    {
        $this->cardStyle = $cardStyle;
        return $this;
    }

    /**
     * @param string $titleMode
     * @return Card
     */
    public function setTitleMode(string $titleMode): Card
    {
        $this->titleMode = $titleMode;
        return $this;
    }


    public function vueData()
    {
        // TODO: Implement vueData() method.
    }

    public function method()
    {
        // TODO: Implement method() method.
    }
}