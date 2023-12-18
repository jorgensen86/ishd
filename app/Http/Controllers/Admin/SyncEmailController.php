<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Imap;
use App\Models\Email;
use App\Models\Ticket;
use App\Models\TicketNumber;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Webklex\IMAP\Facades\Client;

class SyncEmailController extends Controller
{
    const FOLDER = 'email/';
    const FOLDERS = ['spam', 'Trash'];

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index() {
        foreach (Imap::where('active', 1)->get() as $key => $account) {
             $client = Client::make(array(
                'host'          => $account->host,
                'port'          => $account->port,
                'username'      => $account->username,
                'password'      => $account->password,
                'encryption'    => $account->encryption,
                'validate_cert' => $account->validate_cert,
            ));

            try {
                $client->connect();
                $email = Email::find(1);
                dd($email->ticket_number());

                foreach ($client->getFolders() as $key => $folder) {
                    foreach ($folder->messages()->unseen()->get() as $message) {
                        $email = New Email();
                        $email->ticket_id =  ++(Ticket::get()->last())->ticket_id;
                        $email->imap_id = $account->id;
                        $email->queue_id = $account->queue->id;
                        $email->sender = $message->getFrom()->first()->mail;
                        $email->reply = $message->getReplyTo()->first();
                        $email->cc = $message->getCc()->first();
                        $email->subject = iconv_mime_decode($message->getSubject());
                        $email->body = $message->hasHTMLBody() ? $message->getHTMLBody(false) : $message->getTextBody();
                        $email->sent_at = Carbon::parse( $message->getDate())->format('Y-m-d H:i:s');
                        $email->save();
                        
                        $email->ticketNumber()->create(['co'=> 'com']);
                        
                        foreach ($message->attachments as $attach) {

                            $media = $email->addMediaFromString($attach->content)->usingFileName($attach->filename)->toMediaCollection();
                            if($attach->disposition === 'inline') {
                                $email->body = str_replace("cid:{$attach->getId()}", $media->getFullUrl() ,$email->body);
                                $email->update();
                            }
                        }
                        // dd($email);
                    }
                }
                // foreach ($client->getFolder('INBOX')->messages()->unseen()->get() as $message) {
                // }


            } catch(Throwable $th) {

            }
        }
    }

    public function index2(Request $request)
    {
        foreach (Imap::where('active', 1)->get() as $key => $account) {
            $client = Client::make(array(
                'host'          => $account->host,
                'port'          => $account->port,
                'username'      => $account->username,
                'password'      => $account->password,
                'encryption'    => $account->encryption,
                'validate_cert' => $account->validate_cert,
            ));
            try {
                $client->connect();
                
                foreach ($client->getFolder('INBOX')->messages()->unseen()->get() as $message) {
                    // dump($message->getFrom()->first()->mail);

                   
                    // if(!Email::where(['uid' => $message->getUid(), 'imap_id' => $account->id])->exists()) {
                        $ticket_id = Email::orderBy('id', 'DESC')->first()->ticket_id;
                        $email = New Email();
                        $email->ticket_id = ++$ticket_id;
                        
                        $email->uid = $message->getUid();
                        $email->imap_id = $account->id;
                        $email->queue_id = $account->queue->id;
                        $email->sender = $message->getFrom()->first()->mail;
                        $email->reply = $message->getReplyTo()->first();
                        $email->cc = $message->getCc()->first();
                        $email->subject = iconv_mime_decode($message->getSubject());
                        $email->body = $message->hasHTMLBody() ? $message->getHTMLBody(false) : $message->getTextBody();
                        $email->sent_at = Carbon::parse( $message->getDate())->format('Y-m-d H:i:s');
                        $email->save();

           
                        foreach ($message->attachments as $attach) {

                            dd($attach);
                            Storage::put(SELF::FOLDER .  $attach->filename, $attach->content);
                            $email->addMedia(storage_path('app/' . SELF::FOLDER . 'image.png'))->withCustomProperties(['id'=> $attach->x_attachment_id[0]])->toMediaCollection();

                            dump($attach);
    
                            dd();
                        }
    
                        // $message->setFlag(['Seen']);
                    }
                // }                
                die;
            } catch (\Throwable $th) {
                dump($th);
            }
die;
            // dump($client->connect());
        }
    }

    public function check(Imap $imap) {
        $json = [];

        if (request()->ajax()) {
            $client = Client::make(array(
                'host'          => $imap->host,
                'port'          => $imap->port,
                'username'      => $imap->username,
                'password'      => $imap->password,
                'encryption'    => $imap->encryption,
                'validate_cert' => $imap->validate_cert,
            ));
    
            try {
                $client->connect();
                
                $json = array(
                    'message' => __('el.success_connection')
                );

                $client->disconnect();

            } catch (\Throwable $th) {
                $json = array(
                    'message' => $th->getMessage()
                );
            }
        }

        return response()->json($json, 200);
    }
}
