<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Evita intentar migrar varias veces en la misma solicitud.
     */
    private static bool $attemptedAutoMigrate = false;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        if (! app()->runningInConsole()) {
            $this->ensureDatabaseIsInitialized();
        }
    }

    private function ensureDatabaseIsInitialized(): void
    {
        if (self::$attemptedAutoMigrate) {
            return;
        }

        self::$attemptedAutoMigrate = true;

        try {
            if (Schema::hasTable('users') && Schema::hasTable('categories') && Schema::hasTable('products')) {
                return;
            }

            Artisan::call('migrate', ['--force' => true]);
        } catch (Throwable $e) {
            Log::warning('No se pudieron ejecutar migraciones automaticas en runtime.', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}
