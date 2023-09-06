<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Imap;
use App\Models\Email;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;

class SyncEmailController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
                    if(!Email::where(['uid' => $message->getUid(), 'imap_id' => $account->id])->exists()) {
                        
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
                        $email->body = $message->hasHTMLBody() ? $message->getHTMLBody() : $message->getTextBody();
                        $email->sent_at = Carbon::parse( $message->getDate())->format('Y-m-d H:i:s');
                        $email->save();
    
                        $message->setFlag(['Seen']);
                    }
                }                
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
