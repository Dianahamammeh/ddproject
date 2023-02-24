<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductAjaxController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Auth::routes(['verify' => true]);


Route::middleware(['auth','is_admin'])->group(function (){
Route::resource('users', UserController::class);
Route::get('user-porudcts/{id}', [UserController::class,'products'])->name('user.products');
Route::post('delete-user', [UserController::class, 'destroy']);

Route::post('edit', [UserController::class, 'edit']);

Route::post('editnew', [UserController::class, 'update'])->name('editnew');


//Route::resource('product',ProductAjaxController::class);
Route::get('product', [ProductAjaxController::class, 'creat'])->name('product');
Route::post('saveproduct', [ProductAjaxController::class, 'store'])->name('saveproduct');

Route::get('productlist', [ProductAjaxController::class, 'productlist'])->name('productlist');
Route::get('productindex', [ProductAjaxController::class, 'productindex'])->name('productindex');

Route::post('destroypro', [ProductAjaxController::class, 'destroypro'])->name('destroypro');

Route::get('edit_product/{id}', [ProductAjaxController::class, 'edit_product'])->name('edit_product');

Route::post('editnewproduct/{id}', [ProductAjaxController::class, 'editnewproduct'])->name('editnewproduct');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');;
});

//Route::get('view',[ProductAjaxController::class,'view'])->name('view');


Route::get('/auth', function () {
    return view('layouts.auth')->name('layouts');
});
Route::get('/dashboard', function () {
    return view('auth.dashboard')->name('dashboard');

});
Auth::routes();

Route::get('/user-home', [HomeController::class, 'userIndex'])->name('user-home')->middleware('verified');;

// Auth::routes();
//  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->Middleware('auth');
