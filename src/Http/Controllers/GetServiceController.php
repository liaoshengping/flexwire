<?php

namespace Liaosp\Flexwire\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Liaosp\Flexwire\Services\AsyncServiceAbstract;
use Liaosp\Flexwire\Services\ToolService;

class GetServiceController
{
    public function success($msg='操作成功')
    {
        return [
            'code' => 200,
            'msg' => $msg,
            'message' => $msg,
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

    public function handle2(Request $request)
    {
        try {
            $class_name = $request->input('class_name');
            $className = (new ToolService())->decode($class_name);
            $obj = new $className();
            return $obj->handle();
        }catch (\Exception $exception){
            return  $this->fail($exception->getMessage());
        }

    }

    public function handle(Request $request)
    {
        $function = $request->input('currentFunction');

        $class = base64_decode($function);
        /**
         * @var AsyncServiceAbstract $class
         */
        $class = new $class();
        $class->setRequest($request,$function);
        return $class->handle();


    }
}