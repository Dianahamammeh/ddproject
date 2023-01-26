<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductAjaxController;
use App\Http\Middleware;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.register');
});



Route::resource('users', UserController::class)->Middleware('auth');
Route::post('delete-user', [UserController::class,'destroy'])->Middleware('auth');

Route::post('edit', [UserController::class,'edit'])->Middleware('auth');

Route::post('editnew', [UserController::class,'update'])->name('editnew')->Middleware('auth');


//Route::resource('product',ProductAjaxController::class);
Route::get('product',[ProductAjaxController::class,'creat'])->name('product')->Middleware('auth');
Route::post('saveproduct',[ProductAjaxController::class,'store'])->name('saveproduct')->Middleware('auth');

Route::get('productlist',[ProductAjaxController::class,'productlist'])->name('productlist')->Middleware('auth');
Route::get('productindex',[ProductAjaxController::class,'productindex'])->name('productindex')->Middleware('auth');

Route::get('destroypro/{id}', [ProductAjaxController::class,'destroypro'])->name('destroypro')->Middleware('auth');

Route::get('edit_product/{id}', [ProductAjaxController::class,'edit_product'])->name('edit_product')->Middleware('auth');

Route::post('editnewproduct/{id}', [ProductAjaxController::class,'editnewproduct'])->name('editnewproduct')->Middleware('auth');

 
//Route::get('view',[ProductAjaxController::class,'view'])->name('view');




Route::get('/auth', function () {
    return view('layouts.auth')->name('layouts');
});
Route::get('/dashboard', function () {
    return view('auth.dashboard')->name('dashboard');

});
Auth::routes();
 
//Route::get('/home',[HomeController::class,'index'])->name('home');

Auth::routes();
 Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->Middleware('auth');
