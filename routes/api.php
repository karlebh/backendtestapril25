<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\UserController;
use App\Http\Middleware\AdminAndManagerAccess;
use App\Http\Middleware\AdminOnlyAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->middleware(AdminOnlyAccess::class);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::post('/expenses', [ExpenseController::class, 'store']);
    Route::put('/expenses/{id}', [ExpenseController::class, 'update'])->middleware(AdminAndManagerAccess::class);


    Route::group(['middleware' => AdminOnlyAccess::class], function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);

        Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy']);
    });
});
