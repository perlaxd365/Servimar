<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;

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
    return view('auth.login');
});

Route::get('logout', function () {
    return view('auth.login');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return view('dash.index');
    })->name('dash');
});


Route::resource('users', UserController::class)->names('admin.users');


Route::resource('clientes', ClienteController::class)->names('admin.clientes');


Route::resource('products', ProductController::class)->names('admin.products');


Route::resource('ventas', VentaController::class)->names('admin.ventas');

