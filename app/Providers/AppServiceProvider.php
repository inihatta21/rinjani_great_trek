<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        $this->ensurePublicStorageLink();

        RateLimiter::for('admin-login', function (Request $request) {
            $username = (string) $request->input('username', '');

            return Limit::perMinute(5)->by($request->ip().'|'.$username);
        });

        RateLimiter::for('admin-forgot-password', function (Request $request) {
            $username = (string) $request->input('username', '');

            return Limit::perMinute(3)->by($request->ip().'|'.$username);
        });

        RateLimiter::for('admin-reset-password', function (Request $request) {
            $username = (string) $request->input('username', '');

            return Limit::perMinute(5)->by($request->ip().'|'.$username);
        });
    }

    private function ensurePublicStorageLink(): void
    {
        $publicStoragePath = public_path('storage');
        $storagePublicPath = storage_path('app/public');

        if (! is_dir($storagePublicPath)) {
            return;
        }

        if (is_link($publicStoragePath) || is_dir($publicStoragePath)) {
            return;
        }

        try {
            File::link($storagePublicPath, $publicStoragePath);
        } catch (\Throwable) {
            // Shared hosting can block symlink creation; fallback route handles this case.
        }
    }
}
