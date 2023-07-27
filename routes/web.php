<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
Route::get('/testEmail', function() {

    $to_name = "takis";
$to_email = "jorg.icop@gmail.com";
$data = array("name"=>"Icop Email", "body" => "A test mail");
Mail::send("test", $data, function($message) use ($to_name, $to_email) {
$message->to($to_email, $to_name)
->subject("Laravel Test Mail");
$message->from("ganast@icop.gr","Test Mail");
});

});

Auth::routes(['register' => false, 'reset' => false, 'confirm' => false]);

Route::get('logout', [\App\Http\Controllers\Auth\LogoutController::class, 'index'])->name('logout');

Route::get('/', function () {
    if(Auth::user()) {
        if(Auth::user()->administrator) {
            return redirect('dashboard');
        } else {
            return redirect('client/dashboard');
        }
    } else {
        return redirect('login');
    }
});


Route::middleware(['auth','client'])->prefix('client')->group(function() {
    Route::get('/dashboard', [App\Http\Controllers\Client\HomeController::class, 'index'])->name('client.dashboard');

    Route::name('client.')->group(function () {
        Route::resource('ticket',  App\Http\Controllers\Client\TicketController::class)->except(['edit', 'update']);
    });
});

Route::middleware(['auth','admin'])->group(function() {
    // Route::get('/', function () { return redirect('/dashboard'); });

    Route::get('/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');

    Route::post('uploadMedia', App\Http\Controllers\Admin\UploadMediaController::class)->name('upload');

    Route::get('/invoice', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoice.index');

    Route::get('reply', [App\Http\Controllers\Admin\ReplyController::class, 'create'])->name('reply.create');
    Route::post('reply/store', [App\Http\Controllers\Admin\ReplyController::class, 'store'])->name('reply.store');

    Route::get('notification/{type}/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notification.index');
    Route::post('notification/store', [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notification.store');
    
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

    Route::prefix('email')->group(function () {
        Route::resource('email',  App\Http\Controllers\Admin\EmailController::class);
        Route::get('queue/{queue_id?}',  [App\Http\Controllers\Admin\EmailController::class, 'index'])->name('email.index');;
        Route::resource('imap',  App\Http\Controllers\Admin\ImapController::class)->except(['show']);
        Route::get('sync',  [App\Http\Controllers\Admin\SyncEmailController::class, 'index']);
        Route::get('checkConnection/{imap}',  [App\Http\Controllers\Admin\SyncEmailController::class, 'check'])->name('checkConnection');
    });

    Route::prefix('ticket')->group(function () {
        Route::resource('ticket',  App\Http\Controllers\Admin\TicketController::class)->except(['edit', 'update']);
        Route::get('queue/{queue_id?}',  [App\Http\Controllers\Admin\TicketController::class, 'index'])->name('ticket.index');
    });
});

