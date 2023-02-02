<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\passportAuthController;
use App\Http\Controllers\ProductAjaxController;
use App\Http\Controllers\LoginUserRequest;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register',[passportAuthController::class,'registerUserExample']);
Route::post('login',[passportAuthController::class,'login']);

//Route::post('login', [passportAuthController::class, 'login'])->name('auth.login');

Route::post('logout',[passportAuthController::class,'Logout']);


//Route::get('get_pro',[ProductAjaxController::class , 'get_pro'])->name('get_pro');
//Route::resource('/tasks',TasksController::class);




Route::apiResource('products', ProductApiController::class)->middleware('auth:api');

Route::apiResource('user', UserApiController::class)->middleware('auth:api');

//Route::delete('delete', ' ProductApiController::class');
