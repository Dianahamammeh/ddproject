<?php

use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;


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

Route::post('/user/register', [UserApiController::class, 'register']);
Route::post('/user/login', [UserApiController::class, 'login']);
Route::post('/user/resendotp', [UserApiController::class, 'sendOTP']);
Route::post('/user/verify', [UserApiController::class, 'verifyEmail']);
Route::post('/user/update/{id}', [UserApiController::class, 'update'])
    ->middleware('auth:api');
Route::post('/user/assign/{id}', [UserApiController::class, 'assignProducts'])
    ->middleware('auth:api');

Route::delete('/user/{id}', [UserApiController::class, 'delete'])
    ->middleware('auth:api');
Route::get('/user/{id}', [UserApiController::class, 'details'])
    ->middleware('auth:api');
    
Route::get('user', [UserApiController::class, 'list']);



Route::post('/product', [ProductApiController::class, 'create'])
    ->middleware('auth:api');
Route::get('/product', [ProductApiController::class, 'index'])
    ->middleware('auth:api');
Route::post('/product/update/{id}', [ProductApiController::class, 'update'])
    ->middleware('auth:api');
Route::get('/product/user/{id}', [ProductApiController::class, 'user'])
    ->middleware('auth:api');

Route::delete('/product/{id}', [ProductApiController::class, 'delete'])
    ->middleware('auth:api');
Route::get('/product/{id}', [ProductApiController::class, 'details'])
    ->middleware('auth:api');


Route::get('test', function () {
    return response([
        "message" => 'Authenticated!'
    ], 200);
});
