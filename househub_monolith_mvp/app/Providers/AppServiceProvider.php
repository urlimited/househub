<?php

namespace App\Providers;

use App\Contracts\AuthCodeRepositoryContract;
use App\Contracts\NotificatorRepositoryContract;
use App\Contracts\UserRepositoryContract;
use App\Repositories\AuthCodeRepository;
use App\Repositories\NotificatorRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(AuthCodeRepositoryContract::class, AuthCodeRepository::class);
        $this->app->bind(NotificatorRepositoryContract::class, NotificatorRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
