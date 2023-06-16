<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    const LAYOUT_PATH = 'layouts.admin.ticket.reply';
    const PAGE_CLASS = 'replyPage';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            return view(self::LAYOUT_PATH . 'Form')
                ->with('title', 'Απάντηση')
                ->with('action', route('queue.store'))
                ->with('method', 'post')
                ->with('reply', new Reply());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $reply = new Reply();
        $reply->create([
            'ticket_id' => $request->ticket_id,
            'author_id' => $request->author_id,
            'body' => $request->body,
        ]);

        return redirect()->back();
    }
}
