<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

//Auth Routes;
Route::post("register", [AuthController::class , 'register']);
Route::post("login",[AuthController::class , 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post("logout",[AuthController::class , 'logout']);
    Route::get("user",[AuthController::class , 'user']);
});
