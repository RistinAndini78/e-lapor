<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PengaduanController;

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');

    // Public Data
    Route::get('categories', function () {
        return response()->json(\App\Models\Category::all());
    });
    Route::get('pengaduan-publik', [App\Http\Controllers\Api\PengaduanController::class, 'indexPublic']);
});
Route::group(['middleware' => ['auth:api']], function () {
    // User Management (Admin Only)
    Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
    Route::patch('pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->middleware('role:admin');
    
    // CRUD Access for Authenticated Users (Masyarakat & Admin)
    Route::apiResource('pengaduan', PengaduanController::class);
});
