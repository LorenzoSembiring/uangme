<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\InvestmentController;


Route::group(['middleware' => 'api'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::prefix('borrower')->group(function () {
        Route::get('limit', [BorrowerController::class, 'loanLimit'])->middleware('auth:api');;
    });

    Route::prefix('investment')->group(function () {
        Route::post('/', [InvestmentController::class, 'add'])->middleware('auth:api');;
        Route::get('total', [InvestmentController::class, 'total'])->middleware('auth:api');;
        Route::get('history', [InvestmentController::class, 'history'])->middleware('auth:api');;
    });
});
