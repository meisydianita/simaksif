<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use App\Observers\MemberObserver;
use App\Models\Member;

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
         Paginator::useBootstrapFive();
         Collection::macro('padArray', function ($size, $default = 0) {
         return $this->pad($size, $default)->values()->all();
         Member::observe(MemberObserver::class);

    });
        // Paginator::useTailwind();
    }
}
