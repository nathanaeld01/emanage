<?php

namespace App\Providers;

use App\Models\Administrator;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Relation::enforceMorphMap([
            'administrator' => Administrator::class,
            'employee' => Employee::class,
            'client' => Client::class,
        ]);
    }
}
