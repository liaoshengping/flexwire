<?php

namespace Liaosp\Flexwire\Services;

use Illuminate\Http\Request;

abstract class AsyncServiceAbstract
{
    /**
     * @var Request $request
     */
    protected $request;


    protected $keyName;


    abstract public function handle();

    public function data(): array
    {
        return [];
    }

    /**
     * @param mixed $request
     * @return AsyncServiceAbstract
     */
    public function setRequest($request, $keyName)
    {
        $this->request = $request;

        $this->keyName = $keyName;

        return $this;
    }


}