<?php

namespace App\Providers;

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
        $this->app->bind(
            'App\Repositories\User\UserRepositoryInterface',
            'App\Repositories\User\UserRepository'
        );
        $this->app->bind(
            'App\Repositories\PhotoUser\PhotoUserRepositoryInterface',
            'App\Repositories\PhotoUser\PhotoUserRepository'
        );
        $this->app->bind(
            'App\Repositories\PersonalAccessTokens\PersonalAccessTokensRepositoryInterface',
            'App\Repositories\PersonalAccessTokens\PersonalAccessTokensRepository'
        );
    }
}
