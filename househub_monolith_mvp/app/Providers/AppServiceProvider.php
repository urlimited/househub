<?php

namespace App\Providers;

use App\Contracts\Repositories\AuthCodeRepositoryContract;
use App\Contracts\Repositories\NotificatorRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\TokenServiceContract;
use App\Repositories\AuthCodeRepository;
use App\Repositories\NotificatorRepository;
use App\Repositories\UserRepository;
use App\Services\JWTTokenService;
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

        $this->app->bind(TokenServiceContract::class, JWTTokenService::class);
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
