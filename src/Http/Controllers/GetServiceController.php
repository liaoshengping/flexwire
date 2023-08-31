<?php

namespace Liaosp\Flexwire\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Liaosp\Flexwire\Services\AsyncServiceAbstract;

class GetServiceController
{
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