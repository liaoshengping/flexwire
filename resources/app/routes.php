<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', [\Liaosp\Flexwire\Http\Controllers\DemoController::class,'index']);
Route::get('/form', [\Liaosp\Flexwire\Http\Controllers\FormController::class,'resetCode']);
Route::post('/async', [\Liaosp\Flexwire\Http\Controllers\GetServiceController::class,'handle']);

Route::post('/get-service', [\Liaosp\Flexwire\Http\Controllers\GetServiceController::class,'handle']);

#获取config数据
Route::middleware(config('flexwire.middleware'))->post('/get-service2', [\Liaosp\Flexwire\Http\Controllers\GetServiceController::class,'handle2']);


//Liaosp\Flexwire\Http\Controllers

Route::prefix('h5')->middleware(['flexwire.auth'])->group(function (){
    Route::any("/{controller}/{action}",function ($class, $action){
        $class = "App\\FlexWire\\Controllers\\".\Illuminate\Support\Str::studly($class);
        if(class_exists($class))
        {
            $ctrl = \Illuminate\Support\Facades\App::make($class);
            return \Illuminate\Support\Facades\App::call([$ctrl, $action]);
        }
        return abort(404);

    })->where([ 'module'=>'[0-9a-zA-Z]+','class' => '[0-9a-zA-Z]+', 'action' => '[0-9a-zA-Z]+']);
});
