<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';
    public const DASHBOARD = '/dashboard';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        Route::middleware(['web', 'auth'])->group(function () {
            // Administrator
            $this->mapDashboardRoutes();
            $this->mapUserRoutes();
            $this->mapMenuRoutes();
            $this->mapOtoritasRoutes();

            // GMPA
            $this->mapArusKasRoutes();
            $this->mapDanaUniversitasRoutes();
            $this->mapSuratRoutes();
            $this->mapRefDivisiRoutes();
            $this->mapRefSubDivisiRoutes();

            // Umum
            $this->mapPesanRoutes();
            $this->mapSettingsRoutes();
            $this->mapStrukturOrganisasiRoutes();
            $this->mapAchievementsRoutes();
            $this->mapInventarisasiRoutes();
            $this->mapJadwalPiketRoutes();
            $this->mapPeminjamanRoutes();
            $this->mapKerjaBaktiRoutes();
            $this->mapPemancarRoutes();

            // Kepenyiaran
            $this->mapPenyiarRoutes();
            $this->mapProgramSiarRoutes();
            $this->mapRefProgramSiarRoutes();
            $this->mapRefJenisProgramSiarRoutes();
            $this->mapTopChartsRoutes();
            $this->mapRapmaNewsRoutes();
            $this->mapJadwalSiarRoutes();
            $this->mapPodcastRoutes();

            // Marketing
            $this->mapEventsRoutes();

            // Personalia
            $this->mapCrewRoutes();
            $this->mapPengurusRoutes();
            $this->mapAlumniRoutes();
        });
    }

    // Administrator
    protected function mapWebRoutes()
    {
        Route::middleware('web')->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')->middleware('api')->group(base_path('routes/api.php'));
    }

    protected function mapDashboardRoutes()
    {
        Route::prefix('dashboard')->group(base_path('routes/panel/dashboard.php'));
    }

    protected function mapUserRoutes()
    {
        Route::prefix('users')->group(base_path('routes/panel/users.php'));
    }

    protected function mapMenuRoutes()
    {
        Route::prefix('manajemen-menu')->group(base_path('routes/panel/menu.php'));
    }

    protected function mapOtoritasRoutes()
    {
        Route::prefix('otoritas')->group(base_path('routes/panel/otoritas.php'));
    }

    // GMPA
    protected function mapArusKasRoutes()
    {
        Route::prefix('arus-kas')->group(base_path('routes/panel/gmpa/arus-kas.php'));
    }

    protected function mapDanaUniversitasRoutes()
    {
        Route::prefix('dana-universitas')->group(base_path('routes/panel/gmpa/dana-universitas.php'));
    }

    protected function mapSuratRoutes()
    {
        Route::prefix('surat')->group(base_path('routes/panel/gmpa/surat.php'));
    }

    protected function mapRefDivisiRoutes()
    {
        Route::prefix('ref-divisi')->group(base_path('routes/panel/gmpa/ref-divisi.php'));
    }

    protected function mapRefSubDivisiRoutes()
    {
        Route::prefix('ref-sub-divisi')->group(base_path('routes/panel/gmpa/ref-sub-divisi.php'));
    }

    // Umum
    protected function mapPesanRoutes()
    {
        Route::prefix('pesan')->group(base_path('routes/panel/umum/pesan.php'));
    }

    protected function mapSettingsRoutes()
    {
        Route::prefix('settings')->group(base_path('routes/panel/umum/settings.php'));
    }

    protected function mapStrukturOrganisasiRoutes()
    {
        Route::prefix('struktur-organisasi')->group(base_path('routes/panel/umum/struktur-organisasi.php'));
    }

    protected function mapAchievementsRoutes()
    {
        Route::prefix('achievements')->group(base_path('routes/panel/umum/achievements.php'));
    }

    protected function mapInventarisasiRoutes()
    {
        Route::prefix('inventarisasi')->group(base_path('routes/panel/umum/inventarisasi.php'));
    }

    protected function mapJadwalPiketRoutes()
    {
        Route::prefix('jadwal-piket')->group(base_path('routes/panel/umum/jadwal-piket.php'));
    }

    protected function mapPeminjamanRoutes()
    {
        Route::prefix('peminjaman')->group(base_path('routes/panel/umum/peminjaman.php'));
    }

    protected function mapKerjaBaktiRoutes()
    {
        Route::prefix('kerja-bakti')->group(base_path('routes/panel/umum/kerja-bakti.php'));
    }

    protected function mapPemancarRoutes()
    {
        Route::prefix('pemancar')->group(base_path('routes/panel/umum/pemancar.php'));
    }

    // Kepenyiaran
    protected function mapPenyiarRoutes()
    {
        Route::prefix('penyiar')->group(base_path('routes/panel/kepenyiaran/penyiar.php'));
    }

    protected function mapProgramSiarRoutes()
    {
        Route::prefix('program-siar')->group(base_path('routes/panel/kepenyiaran/program-siar.php'));
    }

    protected function mapRefProgramSiarRoutes()
    {
        Route::prefix('ref-program-siar')->group(base_path('routes/panel/kepenyiaran/ref-program-siar.php'));
    }

    protected function mapRefJenisProgramSiarRoutes()
    {
        Route::prefix('ref-jenis-program-siar')->group(base_path('routes/panel/kepenyiaran/ref-jenis-program-siar.php'));
    }

    protected function mapTopChartsRoutes()
    {
        Route::prefix('top-charts')->group(base_path('routes/panel/kepenyiaran/top-charts.php'));
    }

    protected function mapRapmaNewsRoutes()
    {
        Route::prefix('rapma-news')->group(base_path('routes/panel/kepenyiaran/rapma-news.php'));
    }

    protected function mapJadwalSiarRoutes()
    {
        Route::prefix('jadwal-siar')->group(base_path('routes/panel/kepenyiaran/jadwal-siar.php'));
    }

    protected function mapPodcastRoutes()
    {
        Route::prefix('podcast')->group(base_path('routes/panel/kepenyiaran/podcast.php'));
    }

    // Marketing
    protected function mapEventsRoutes()
    {
        Route::prefix('events')->group(base_path('routes/panel/marketing/events.php'));
    }

    // Personalia
    protected function mapCrewRoutes()
    {
        Route::prefix('crew')->group(base_path('routes/panel/personalia/crew.php'));
    }

    protected function mapPengurusRoutes()
    {
        Route::prefix('pengurus')->group(base_path('routes/panel/personalia/pengurus.php'));
    }

    protected function mapAlumniRoutes()
    {
        Route::prefix('alumni')->group(base_path('routes/panel/personalia/alumni.php'));
    }
}
