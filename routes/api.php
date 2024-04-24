<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewssController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource("news" , NewsController::class);
    Route::get("new/search/{category_name}", [NewsController::class, "searchByCategory"]);
});

Route::controller(AuthController::class)->group(function () {
    Route::middleware("guest")->group(function () {
        Route::post("register", "register");
        Route::post("login", "login");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::get("profile", "profile");
        Route::post("logout", "logout");
    });
});

