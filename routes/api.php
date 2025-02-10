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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

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
        Route::apiResource('users', UserController::class);
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
        // Route::get('transcations/{transaction}', [TransactionController::class, 'show'])->name('transcations.show');
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
