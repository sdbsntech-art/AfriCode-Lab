<?php

namespace App\Providers;

use App\Models\Membership;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View as ViewFacade;

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
        ViewFacade::composer('layouts.admin', function (View $view): void {
            $view->with(
                'pendingMembershipsCount',
                Membership::where('status', 'pending')->count(),
            );
        });
    }
}
