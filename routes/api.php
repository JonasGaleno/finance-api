<?php

use App\Http\Controllers\{
    AuthController,
    BudgetController,
    CategoryController,
    FinancialGoalController,
    PaymentMethodController,
    TransactionController,
    UserController
};
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware(['auth:api'])->group(function(){
    /* Auth */
    Route::group([], function () {
        Route::post('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    /* Users */
    Route::group([], function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    /* Payment Methods */
    Route::group([], function () {
        Route::apiResource('payment-methods', PaymentMethodController::class);
    });

    /* Categories */
    Route::group([], function () {
        Route::apiResource('categories', CategoryController::class);
    });

    /* Transactions */
    Route::group([], function () {
        Route::apiResource('transactions', TransactionController::class);
    });

    /* Financial Goals */
    Route::group([], function () {
        Route::apiResource('financial-goals', FinancialGoalController::class);
    });

    /* Budgets */
    Route::group([], function () {
        Route::apiResource('budgets', BudgetController::class);
    });
});
