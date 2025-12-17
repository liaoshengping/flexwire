<?php
namespace Liaosp\Flexwire;

use App\H5\Middleware\H5Auth;
use Dcat\Admin\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{


    public function boot(Router $router)
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../resources/config' => config_path()], 'flexwire-config');
            $this->publishes([__DIR__.'/../resources/dist' =>  public_path('vendor/flexware'),], 'flexwire-assets');
            $this->publishes([__DIR__.'/../resources/app' =>  app_path('FlexWire'),], 'flexwire-app');
        }
        $router->aliasMiddleware('flexwire.auth', \Liaosp\Flexwire\Http\Middleware\H5Auth::class);
    }


    public function register()
    {
        app('view')->prependNamespace('flexwire', __DIR__ . '/views');

        $this->registerRoute();

    }


    private function registerRoute(){
        Route::group($this->routeConfiguration(),function (){
            if (file_exists(app_path('FlexWire/routes.php'))){
                $this->loadRoutesFrom(app_path('FlexWire/routes.php'));
            }
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
            'middleware' => ['web'],

//            'middleware' => '',
        ];
    }



}