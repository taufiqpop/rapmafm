<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    // protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/check-access';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        Route::middleware(['web', 'auth'])->group(function () {

            $this->mapDashboardRoutes();

            $this->mapUserRoutes();

            $this->mapTerminologiRoutes();

            $this->mapMenuRoutes();

            $this->mapOtoritasRoutes();

            $this->mapPerumusanRoutes();

            $this->mapPenyampaianRoutes();

            $this->mapImplementasiRoutes();

            $this->mapFeedbackRoutes();

            $this->mapMonitoringRoutes();

            $this->mapKetercapaianRoutes();

            $this->mapMateriMatpelRoutes();
        });
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
            // ->namespace($this->namespace)
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
            // ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapDashboardRoutes()
    {
        Route::prefix('dashboard')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/dashboard.php'));
    }

    protected function mapUserRoutes()
    {
        Route::prefix('users')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/users.php'));
    }

    protected function mapTerminologiRoutes()
    {
        Route::prefix('terminologi')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/terminologi.php'));
    }

    protected function mapMenuRoutes()
    {
        Route::prefix('manajemen-menu')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/menu.php'));
    }

    protected function mapOtoritasRoutes()
    {
        Route::prefix('otoritas')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/otoritas.php'));
    }
    protected function mapPerumusanRoutes()
    {
        Route::prefix('perumusan')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/perumusan.php'));
    }

    protected function mapPenyampaianRoutes()
    {
        Route::prefix('penyampaian')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/penyampaian.php'));
    }
    protected function mapImplementasiRoutes()
    {
        Route::prefix('implementasi')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/implementasi.php'));
    }

    protected function mapFeedbackRoutes()
    {
        Route::prefix('feedback')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/feedback.php'));
    }

    protected function mapMonitoringRoutes()
    {
        Route::prefix('monitoring-peserta-didik')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/monitoring.php'));
    }

    protected function mapKetercapaianRoutes()
    {
        Route::prefix('ketercapaian-tujuan')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/ketercapaian.php'));
    }

    protected function mapMateriMatpelRoutes()
    {
        Route::prefix('materi-matpel')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/materi_matpel.php'));
    }
}
