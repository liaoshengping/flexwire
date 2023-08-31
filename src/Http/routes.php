<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', [\Liaosp\Flexwire\Http\Controllers\DemoController::class,'index']);
Route::post('/async', [\Liaosp\Flexwire\Http\Controllers\GetServiceController::class,'handle']);

Route::post('/get-service', [\Liaosp\Flexwire\Http\Controllers\GetServiceController::class,'handle']);
