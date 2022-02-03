<?php

namespace App\Providers;

use App\Contracts\Repositories\AuthCodeRepositoryContract;
use App\Contracts\Repositories\CompanyRepositoryContract;
use App\Contracts\Repositories\NotificatorRepositoryContract;
use App\Contracts\Repositories\RealEstateRepositoryContract;
use App\Contracts\Repositories\TokenRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\TokenServiceContract;
use App\Exceptions\UnknownGrammarClass;
use App\Repositories\AuthCodeRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\NotificatorRepository;
use App\Repositories\RealEstateRepository;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use App\Services\JWTTokenService;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Fluent;
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
        $this->app->bind(TokenRepositoryContract::class, TokenRepository::class);
        $this->app->bind(RealEstateRepositoryContract::class, RealEstateRepository::class);
        $this->app->bind(CompanyRepositoryContract::class, CompanyRepository::class);

        $this->app->bind(TokenServiceContract::class, JWTTokenService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Grammar::macro('typeEfficientUuid', function (Fluent $column) {
            return match (class_basename(static::class)) {
                'MySqlGrammar' => sprintf('binary(%d)', $column->length ?? 16),
                'PostgresGrammar' => 'bytea',
                'SQLiteGrammar' => 'blob(256)',
                default => throw new UnknownGrammarClass,
            };
        });

        Blueprint::macro('efficientUuid', function ($column): ColumnDefinition {
            /** @var Blueprint $this */
            return $this->addColumn('efficientUuid', $column);
        });
    }
}
