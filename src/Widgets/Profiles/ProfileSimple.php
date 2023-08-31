<?php

namespace Liaosp\Flexwire\Widgets\Profiles;

use Illuminate\Contracts\Support\Renderable;
use Liaosp\Flexwire\Component\Cell;
use Liaosp\Flexwire\Component\Image;
use Liaosp\Flexwire\layout\Column;
use Liaosp\Flexwire\layout\Row;
use Liaosp\Flexwire\Widgets\WidgetAbstract;

class ProfileSimple extends WidgetAbstract implements Renderable
{

    protected $image;
    protected $username;
    protected $contents;

    public function __construct($image = 'http://wx.qlogo.cn/mmhead/Q3auHgzwzM7XJ3q16a3Op4ncyXPAXQBFnSyMvPTgyLq2R3YtmlbXYQ/0', $username = '', $contents = [])
    {
        $this->image = $image;
        $this->username = $username;
        if (!is_array($contents)) {
            throw new \Exception('content must array');
        }
        $this->contents = $contents;
    }

    public function render()
    {
        $newRow = new Row();
        $newRow->justifyCenter();
        $newRow->column(0, function (Column $column) {
            $column->widthFull();
            $column->row(function (Row $row) {
                $row->column(0, function (Column $column) {
                    $column->widthFull();
                    $column->textAlignCenter();
                    $column->append(Image::make($this->image)
                        ->round());
                    $column->append('<h4 style="margin-top: 10px">' . $this->username . '</h4>');
                });
            });
            if ($this->contents) $column->append(Cell::make($this->contents));

        });

        return $newRow->render();
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
     * @param array $contents
     * @return ProfileSimple
     */
    public function setContents(array $contents): ProfileSimple
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * @param mixed|string $username
     * @return ProfileSimple
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }


}