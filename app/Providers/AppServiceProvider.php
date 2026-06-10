<?php

namespace App\Providers;

use App\Models\GigApplication;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Inject new-application count into the client sidebar on every page it appears,
        // without running a raw DB query inside the Blade template itself.
        View::composer('partials.sidebar-client', function ($view) {
            $count = 0;

            if (Auth::check() && Auth::user()->role === 'client') {
                $count = GigApplication::whereHas(
                    'gig',
                    fn($q) => $q->where('user_id', Auth::id())
                )
                ->where('created_at', '>=', now()->subHours(48))
                ->count();
            }

            $view->with('_newAppsCount', $count);
        });

        Paginator::useBootstrapFive();

    }
}
