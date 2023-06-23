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

    Route::get('/', function () { return redirect('/dashboard'); });

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::post('uploadMedia', App\Http\Controllers\Admin\UploadMediaController::class)->name('upload');

    Route::get('/invoice', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoice.index');

    Route::get('reply', [App\Http\Controllers\Admin\ReplyController::class, 'create'])->name('reply.create');
    Route::post('reply/store', [App\Http\Controllers\Admin\ReplyController::class, 'store'])->name('reply.store');

    Route::get('notification/ticket/{ticket}', [App\Http\Controllers\Admin\NotificationController::class, 'ticket'])->name('notification.ticket');
    Route::get('notification/reply/{reply}', [App\Http\Controllers\Admin\NotificationController::class, 'reply'])->name('notification.reply');
    
    Route::prefix('setting')->group(function() {
        Route::get('setting',  [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('setting.index');
        Route::post('setting',  [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('setting.save');
        Route::resource('permission',  App\Http\Controllers\Admin\PermissionController::class)->except(['show']);
        Route::resource('role',  App\Http\Controllers\Admin\RoleController::class)->except(['show']);
        Route::resource('queue',  App\Http\Controllers\Admin\QueueController::class)->except(['show']);
        Route::resource('subject',  App\Http\Controllers\Admin\SubjectController::class)->except(['show']);
    });
    
    Route::prefix('user')->group(function() {
        Route::resource('user',  App\Http\Controllers\Admin\UserController::class)->except(['show']);
        Route::resource('client',  App\Http\Controllers\Admin\ClientController::class)->except(['show']);
    });

    Route::prefix('ticket')->group(function () {
        Route::resource('ticket',  App\Http\Controllers\Admin\TicketController::class);
        Route::get('ticket/queue/{queue_id}',  [App\Http\Controllers\Admin\TicketController::class, 'index'])->name('ticket.index');
    });

});

