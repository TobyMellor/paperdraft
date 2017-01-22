<?php

namespace App\Providers;

<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
=======
use Illuminate\Routing\Router;
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
<<<<<<< HEAD
     * This namespace is applied to your controller routes.
=======
     * This namespace is applied to the controller routes in your routes file.
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
<<<<<<< HEAD
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
=======
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
    }

    /**
     * Define the routes for the application.
     *
<<<<<<< HEAD
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
=======
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
    }
}
