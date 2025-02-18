<?php

namespace App\Providers;

use App\Repositories\{
    AuthRepository,
    AuthRepositoryInterface,
    BudgetRepository,
    BudgetRepositoryInterface,
    CategoryRepository,
    CategoryRepositoryInterface,
    FinancialGoalRepository,
    FinancialGoalRepositoryInterface,
    PaymentMethodRepository,
    PaymentMethodRepositoryInterface,
    TransactionRepository,
    TransactionRepositoryInterface,
    UserRepository,
    UserRepositoryInterface
};
use App\Services\{
    AuthService,
    BudgetService,
    CategoryService,
    FinancialGoalService,
    PaymentMethodService,
    TransactionService,
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

        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(TransactionService::class, function ($app) {
            return new TransactionService($app->make(TransactionRepositoryInterface::class));
        });

        $this->app->bind(BudgetRepositoryInterface::class, BudgetRepository::class);
        $this->app->bind(BudgetService::class, function ($app) {
            return new BudgetService($app->make(BudgetRepositoryInterface::class));
        });

        $this->app->bind(FinancialGoalRepositoryInterface::class, FinancialGoalRepository::class);
        $this->app->bind(FinancialGoalService::class, function ($app) {
            return new FinancialGoalService($app->make(FinancialGoalRepositoryInterface::class));
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
