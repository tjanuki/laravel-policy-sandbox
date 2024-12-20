<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        Gate::define('access-admin', function (User $user) {
//            return $user->hasRole('admin');
//        });
//
//        Gate::define('manage-article', function (User $user, $article) {
//            return Gate::allows('access-admin') || $user->id === $article->user_id;
//        });

        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyRoles([$expression])): ?>";
        });

        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
