<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Subject;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    const LAYOUT_PATH = 'layouts.client.ticket';
    const LANG_PATH = 'ticket.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoices = [];
        $subjects = [];
        
        foreach (Invoice::where('user_id', auth()->user()->user_id)->get() as $invoice) {
            $invoices[] = [
                'id' => $invoice['invoice_id'],
                'name' => $invoice['domain'],
            ];
        }

        foreach (Subject::where('active', 1)->get() as $subject) {
            $subjects[] = [
                'id' => $subject->queue->id,
                'name' => $subject->name,
            ];
        }

        return view(self::LAYOUT_PATH . 'Form')
            ->with('subjects', $subjects)
            ->with('invoices', $invoices)
            ->with('title', __(self::LANG_PATH . 'create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = [];
        
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required',
            'domain_id' => 'required',
            'subject' => 'required|min:3',
            'body' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            $ticket = new Ticket();
            $ticket->ticket_id = ++(Ticket::get()->last())->ticket_id;
            $ticket->author_id = auth()->user()->user_id;
            $ticket->invoice_id = $request->domain_id;
            $ticket->queue_id = $request->subject_id;
            $ticket->subject = $request->subject;
            $ticket->body = $request->body;
            $ticket->save();
            
            foreach ($request->media as $key => $media) {
                if(isset($media['src'])) {
                    $ticket->addMedia(storage_path('app/' .$media['src']))->withResponsiveImages()->toMediaCollection(strpos($media['type'], 'image') === 0 ? 'images' : 'downloads');
                }
            }

            $json['success'] = true;
            $json['redirect'] = route('client.ticket.index');
        }

        return response()->json($json, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
