<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes(['register' => false, 'reset' => false, 'confirm' => false]);

Route::get('logout', [\App\Http\Controllers\Auth\LogoutController::class, 'index'])->name('logout');

Route::middleware(['auth','client'])->group(function() {
    Route::get('/home', function () {
       echo "Homepage";
    })->name('home');
});

Route::middleware(['auth','admin'])->group(function() {
    Route::get('/', function () {
        return redirect('/dashboard');
    });
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::get('/invoice', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/setting', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('setting');
    Route::post('/setting', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('setting');
    
    Route::resource('user/user',  App\Http\Controllers\Admin\UserController::class)->except(['show']);
    Route::resource('user/client',  App\Http\Controllers\Admin\ClientController::class)->except(['show']);
    Route::resource('ticket/ticket',  App\Http\Controllers\Admin\TicketController::class)->except(['show']);
});

