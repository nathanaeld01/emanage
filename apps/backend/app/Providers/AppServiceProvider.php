<?php

namespace App\Providers;

use App\Models\Administrator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Modules\Clients\Models\Client;
use Modules\Employees\Models\Employee;

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
