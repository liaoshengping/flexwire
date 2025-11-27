<?php

namespace Liaosp\Flexwire\Services;

use Dcat\Admin\Support\Helper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;

class ToolService
{
    public static function toolRender($value, $params = [], $newThis = null): string
    {
        if (is_string($value)) {
            return $value;
        }

        if ($value instanceof \Closure) {
            $newThis && ($value = $value->bindTo($newThis));

            $value = $value(...(array)$params);
        }

        if ($value instanceof Renderable) {
            return (string)$value->render();
        }

        if ($value instanceof Htmlable) {
            return (string)$value->toHtml();
        }
        return (string)$value;
    }


    public static function convertToAlphabetic($string) {

        preg_match_all('/[a-zA-Z]+/', $string, $matches);

        $alphabeticString = implode('', $matches[0]);

        $alphabeticString = strtoupper($alphabeticString);

        return $alphabeticString;
    }

    /**
     * 格式化为js代码.
     *
     * @param  array|Arrayable  $value
     * @return string
     */
    public static function format($value)
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode(self::array($value, false));
        }

        return $value;
    }

    /**
     * 把给定的值转化为数组.
     *
     * @param $value
     * @param  bool  $filter
     * @return array
     */
    public static function array($value, bool $filter = true): array
    {
        if ($value === null || $value === '' || $value === []) {
            return [];
        }

        if ($value instanceof \Closure) {
            $value = $value();
        }

        if (is_array($value)) {
        } elseif ($value instanceof Jsonable) {
            $value = json_decode($value->toJson(), true);
        } elseif ($value instanceof Arrayable) {
            $value = $value->toArray();
        } elseif (is_string($value)) {
            $array = null;

            try {
                $array = json_decode($value, true);
            } catch (\Throwable $e) {
            }

            $value = is_array($array) ? $array : explode(',', $value);
        } else {
            $value = (array) $value;
        }

        return $filter ? array_filter($value, function ($v) {
            return $v !== '' && $v !== null;
        }) : $value;
    }


    function encode($string = '', $skey = 'tsxcc1') {

        $strArr = str_split(base64_encode($string));

        $strCount = count($strArr);

        foreach (str_split($skey) as $key => $value)

            $key < $strCount && $strArr[$key].=$value;

        return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));

    }

//解密

    function decode($string = '', $skey = 'tsxcc1') {

        $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);

        $strCount = count($strArr);

        foreach (str_split($skey) as $key => $value)

            $key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];

        return base64_decode(join('', $strArr));

    }

}