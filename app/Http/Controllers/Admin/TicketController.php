<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TicketDataTable;
use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.ticket.ticket';
    const LANG_PATH = 'ticket.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('permission:view_queue_' . request()->route('queue_id') );
    }

    public function index(TicketDataTable $dataTable, $queue_id = null)
    {
        // Queue::findOrFail($queue_id );

        return $dataTable->render(self::LAYOUT_PATH . 'List', [
            'title' => __(self::LANG_PATH . 'title'),
            'queues' => Queue::all(),
            'filter_invoice'=> request()->query('invoice')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(self::LAYOUT_PATH . 'Form')
            ->with('title', __(self::LANG_PATH . 'create'))
            ->with('queues', Queue::where('active', 1)->get());
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
            'queue_id' => 'required',
            'invoice_id' => 'required',
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
            $ticket->invoice_id = $request->invoice_id;
            $ticket->queue_id = $request->queue_id;
            $ticket->subject = $request->subject;
            $ticket->body = $request->body;
            $ticket->is_opened = 1;
            $ticket->save();
            
            foreach ($request->media as $key => $media) {
                if(isset($media['src'])) {
                    $ticket->addMedia(storage_path('app/' .$media['src']))->withResponsiveImages()->toMediaCollection(strpos($media['type'], 'image') === 0 ? 'images' : 'downloads');
                }
            }

            $json['success'] = true;
            $json['redirect'] = route('ticket.index');
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

        if (!$ticket->is_opened) {
            $ticket->update(['is_opened' => 1]);
        }
        
        return view(self::LAYOUT_PATH . 'View')
            ->with('title', __(self::LANG_PATH . 'view'))
            ->with('ticket', $ticket)
            ->with('queues', Queue::where('active',1)->get());
    }

     /**
     * Update the specified resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Ticket $ticket)
    {
        $ticket->queue_id = $request->queue_id;
        $ticket->touch();
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
