<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TicketDataTable;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.ticket.ticket';
    const LANG_PATH = 'admin/ticket/ticket.';
    const PAGE_CLASS = 'ticketPage';
    const COLUMNS = [
        ['data' => 'id'],
        ['data' => 'subject'],
        ['data' => 'user.name'],
        ['data' => 'created_at'],
        ['data' => 'updated_at'],
        ['data' => 'action'],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TicketDataTable $dataTable)
    {
        return $dataTable->render('test');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(self::LAYOUT_PATH . 'Form')
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
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return view(self::LAYOUT_PATH . 'View')
            ->with('title', __(self::LANG_PATH . 'view'))
            ->with('ticket', $ticket);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
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
