<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\Auth\UserRepositoriesInterface as AuthUserRepositoryInterface;
use App\Repositories\Auth\UserRepositories as AuthUserRepositories;
use App\Contracts\Repositories\User\UserRepositoriesInterface as UserRepositoryInterface;
use App\Repositories\User\UserRepositories as UserRepositories;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
        AuthUserRepositoryInterface::class,
        AuthUserRepositories::class
    );
        $this->app->bind(
        UserRepositoryInterface::class,
        UserRepositories::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->ip());
    });
    }
}
