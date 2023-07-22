<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\ErrorHandler\Debug;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function () {
    Route::resource('/product', ProductController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/post', PostController::class);
    Route::resource('/sub-category', SubCategoryController::class);
    // Other authenticated routes
});
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');