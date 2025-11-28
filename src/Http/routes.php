<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', [\Liaosp\Flexwire\Http\Controllers\DemoController::class,'index']);
Route::get('/form', [\Liaosp\Flexwire\Http\Controllers\FormController::class,'resetCode']);
Route::post('/async', [\Liaosp\Flexwire\Http\Controllers\GetServiceController::class,'handle']);

Route::post('/get-service', [\Liaosp\Flexwire\Http\Controllers\GetServiceController::class,'handle']);

#获取config数据
Route::middleware(config('flexwire.middleware'))->post('/get-service2', [\Liaosp\Flexwire\Http\Controllers\GetServiceController::class,'handle2']);
