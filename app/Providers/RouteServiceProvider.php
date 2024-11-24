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
    public const HOME = '/';
    public const DASHBOARD = '/dashboard';

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

            $this->mapMenuRoutes();

            $this->mapOtoritasRoutes();

            $this->mapPesanRoutes();

            $this->mapSettingsRoutes();

            $this->mapPenyiarRoutes();

            $this->mapStrukturOrganisasiRoutes();

            $this->mapEventsRoutes();

            $this->mapProgramSiarRoutes();

            $this->mapRefProgramSiarRoutes();

            $this->mapRefJenisProgramSiarRoutes();

            $this->mapTopChartsRoutes();

            $this->mapAchievementsRoutes();

            $this->mapRapmaNewsRoutes();

            $this->mapCrewRoutes();

            $this->mapPengurusRoutes();

            $this->mapAlumniRoutes();

            $this->mapInventarisasiRoutes();

            $this->mapArusKasRoutes();

            $this->mapDanaUniversitasRoutes();

            $this->mapJadwalSiarRoutes();

            $this->mapJadwalPiketRoutes();

            $this->mapPeminjamanRoutes();

            $this->mapKerjaBaktiRoutes();
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

    protected function mapPesanRoutes()
    {
        Route::prefix('pesan')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/pesan.php'));
    }

    protected function mapSettingsRoutes()
    {
        Route::prefix('settings')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/settings.php'));
    }

    protected function mapPenyiarRoutes()
    {
        Route::prefix('penyiar')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/penyiar.php'));
    }

    protected function mapStrukturOrganisasiRoutes()
    {
        Route::prefix('struktur-organisasi')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/struktur-organisasi.php'));
    }

    protected function mapEventsRoutes()
    {
        Route::prefix('events')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/events.php'));
    }

    protected function mapProgramSiarRoutes()
    {
        Route::prefix('program-siar')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/program-siar.php'));
    }

    protected function mapRefProgramSiarRoutes()
    {
        Route::prefix('ref-program-siar')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/ref-program-siar.php'));
    }

    protected function mapRefJenisProgramSiarRoutes()
    {
        Route::prefix('ref-jenis-program-siar')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/ref-jenis-program-siar.php'));
    }

    protected function mapTopChartsRoutes()
    {
        Route::prefix('top-charts')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/top-charts.php'));
    }

    protected function mapAchievementsRoutes()
    {
        Route::prefix('achievements')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/achievements.php'));
    }

    protected function mapRapmaNewsRoutes()
    {
        Route::prefix('rapma-news')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/rapma-news.php'));
    }

    protected function mapCrewRoutes()
    {
        Route::prefix('crew')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/crew.php'));
    }

    protected function mapPengurusRoutes()
    {
        Route::prefix('pengurus')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/pengurus.php'));
    }

    protected function mapAlumniRoutes()
    {
        Route::prefix('alumni')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/alumni.php'));
    }

    protected function mapInventarisasiRoutes()
    {
        Route::prefix('inventarisasi')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/inventarisasi.php'));
    }

    protected function mapArusKasRoutes()
    {
        Route::prefix('arus-kas')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/arus-kas.php'));
    }

    protected function mapDanaUniversitasRoutes()
    {
        Route::prefix('dana-universitas')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/dana-universitas.php'));
    }

    protected function mapJadwalSiarRoutes()
    {
        Route::prefix('jadwal-siar')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/jadwal-siar.php'));
    }

    protected function mapJadwalPiketRoutes()
    {
        Route::prefix('jadwal-piket')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/jadwal-piket.php'));
    }

    protected function mapPeminjamanRoutes()
    {
        Route::prefix('peminjaman')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/peminjaman.php'));
    }

    protected function mapKerjaBaktiRoutes()
    {
        Route::prefix('kerja-bakti')
            // ->namespace($this->namespace)
            ->group(base_path('routes/panel/kerja-bakti.php'));
    }
}
