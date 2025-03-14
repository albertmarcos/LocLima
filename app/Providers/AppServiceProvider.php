<?php

namespace App\Providers;

use App\Models\Bill;
use App\Models\Routine;
use App\Observers\BillObserver;
use App\Observers\RoutineObserver;
use App\Observers\RoutineTaskObserver;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        if ($this->app->environment('local')) {
            DB::listen(function ($query) {
                Log::info('Query Executed: ' . $query->sql, $query->bindings, $query->time);
            });
        }
        Routine::observe(RoutineObserver::class);
        Routine::observe(RoutineTaskObserver::class);
        Bill::observe(BillObserver::class);
    }
}
