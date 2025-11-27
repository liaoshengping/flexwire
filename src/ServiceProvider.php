<?php
namespace Liaosp\Flexwire;

use Dcat\Admin\Admin;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{


    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../resources/dist' =>  public_path('vendor/flexware'),], 'flexware-assets');
        }
    }


    public function register()
    {
        app('view')->prependNamespace('flexwire', __DIR__ . '/views');

        $this->registerRoute();

    }




    private function registerRoute(){
        Route::group($this->routeConfiguration(),function (){
            $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        });
    }



    /**
     * Get the Telescope route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
//            'domain' => 'Flexwire',
            'namespace' => 'Liaosp\Flexwire\Http\Controllers',
            'prefix' => 'flexwire',
//            'middleware' => '',
        ];
    }



}