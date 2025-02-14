<?php

namespace App\Providers;

use App\Repositories\{
    AuthRepository,
    AuthRepositoryInterface,
    CategoryRepository,
    CategoryRepositoryInterface,
    PaymentMethodRepository,
    PaymentMethodRepositoryInterface,
    UserRepository,
    UserRepositoryInterface
};
use App\Services\{
    AuthService,
    CategoryService,
    PaymentMethodService,
    UserService
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
        });

        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(AuthService::class, function ($app) {
            return new AuthService($app->make(AuthRepositoryInterface::class));
        });

        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
        $this->app->bind(PaymentMethodService::class, function ($app) {
            return new PaymentMethodService($app->make(PaymentMethodRepositoryInterface::class));
        });

        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryService::class, function ($app) {
            return new CategoryService($app->make(CategoryRepositoryInterface::class));
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
