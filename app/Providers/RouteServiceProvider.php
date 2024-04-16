<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    public const HOME = '/admin';
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        $this->configureRateLimiting();
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        /*$this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });*/
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/Admin/users-route.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/Admin/roles-route.php'));

            Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/Admin/permissions-route.php'));

             //////CANASTA///
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/CanastaV2/barrios-route.php'));

            Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/CanastaV2/distritos-route.php'));

            Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/CanastaV2/beneficiarios-route.php'));

            Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/CanastaV2/entregas-route.php'));

            //////////

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/Compras/pedido-parcial-route.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/Compras/orden-compras-route.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/Expochaco/solicitud-route.php'));

            Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/sereges/sereges-route.php'));

            Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/informatica/informatica-route.php'));

            Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/facebook/facebook-route.php'));
    }
}
