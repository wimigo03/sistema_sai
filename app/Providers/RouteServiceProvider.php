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
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/Admin/users-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/Admin/roles-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/Admin/permissions-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/CanastaV2/barrios-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/CanastaV2/distritos-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/CanastaV2/beneficiarios-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/CanastaV2/paquetes-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/CanastaV2/paquetes-barrio-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/CanastaV2/entregas-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/CanastaV2/entrega-beneficiario-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/CanastaV2/periodos-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/pedido-parcial-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/orden-compras-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/proveedor-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/partida-presupuestaria-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/item-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/unidad-medida-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/categoria-programatica-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/solicitud-compra-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/orden-compra-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/ingreso-compra-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/compras/salida-material-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/Expochaco/solicitud-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/sereges/sereges-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/informatica/informatica-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/almacenes/almacen-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/almacenes/inventario-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/facebook/facebook-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/ventanilla/correspondencia-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/ventanilla/correspondencia-local-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/agenda-ejecutiva-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/recursos-humanos/empleado-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/recursos-humanos/area-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/recursos-humanos/file-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/archivos-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/control-interno-route.php'));
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/tipo-archivos-route.php'));
    }
}
