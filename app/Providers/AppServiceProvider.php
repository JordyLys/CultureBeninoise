<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         if (
        app()->environment('production') &&
        Schema::hasTable('type_media') &&
        \DB::table('type_media')->count() === 0
    ) {
        Artisan::call('db:seed', [
            '--force' => true
        ]);
    }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
