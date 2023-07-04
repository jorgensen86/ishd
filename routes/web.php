<?php

use App\Models\Imap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\ClientManager;

Route::get('imap', function(){

    $config['accounts']['default'] = array(
        'host'          => 'icop.gr',
        'port'          => '993',
        'username'      => 'ganast@icop.gr',
        'password'      => '@@14@@343po',
    );
    // $oClient = new Client();

    $account = Imap::find(2);
    $client = Client::make(array(
        'host'          => $account->host,
        'port'          => $account->port,
        'username'      => $account->username,
        'password'      => $account->password,
        'encryption'    => $account->encryption,
        'validate_cert' => $account->validate_cert,
    ));
// dd($client);
    $client->connect();

    // $client = Client::make([
    //     'host'          => 'icop.gr',
    //     'port'          => '993',
    //     'username'      => 'ganast@icop.gr',
    //     'password'      => '@@14@@343po',
    // ]);
    $aFolder = $client->getFolders();

    //Loop through every Mailbox
    /** @var \Webklex\IMAP\Folder $oFolder */
    foreach($aFolder as $oFolder){
        echo '<pre>'; 
         print_r("-----------------------FOLDER -------------------"); 
         echo '</pre>';
        //Get all Messages of the current Mailbox $oFolder
        /** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
        $aMessage = $oFolder->messages()->all()->get();
        
        /** @var \Webklex\IMAP\Message $oMessage */
        foreach($aMessage as $message){
            // echo '<pre>'; 

            echo '<pre>'; 
             print_r($message->getAttachments()->count()); 
             echo '</pre>';
            //  print_r( $message->getUid()); 
            //  echo '</pre>';
            //  echo '<pre>'; 
            //   print_r($message->getFrom()); 
            //   echo '</pre>';
              
            // echo iconv_mime_decode($message->getSubject()).'<br />----------';
            // echo '<pre>'; 
            //  print_r( $message->hasHTMLBody() ? $message->getHTMLBodyWithEmbeddedBase64Images() : $message->getTextBody(false)); 
            //  echo '</pre>';


            // 'email_id' => $account->id,
            // 'uid' => $message->getUid(),
            // 'sender' => $message->getFrom()[0]->mail,
            // 'subject' => $message->getSubject(),
            // 'body' => $message->hasHTMLBody() ? $message->getHTMLBody() : $message->getTextBody(),
            
            //Move the current Message to 'INBOX.read'
            // if($oMessage->moveToFolder('INBOX.read') == true){
            //     echo 'Message has ben moved';
            // }else{
            //     echo 'Message could not be moved';
            // }
        }
    }
});

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
        Route::resource('email',  App\Http\Controllers\Admin\TicketController::class);
        Route::resource('imap',  App\Http\Controllers\Admin\ImapController::class)->except(['show']);
    });

    Route::prefix('ticket')->group(function () {
        Route::resource('ticket',  App\Http\Controllers\Admin\TicketController::class);
        Route::get('queue/{queue_id?}',  [App\Http\Controllers\Admin\TicketController::class, 'index'])->name('ticket.index');
    });
});

