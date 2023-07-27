<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\EmailDataTable;
use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\Queue;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.email.email';
    const LANG_PATH = 'admin/email/email.';
    const PAGE_CLASS = 'emailPage';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmailDataTable $emailDataTable, $queue_id = null)
    {
        Queue::findOrFail($queue_id);
        
        return $emailDataTable->render(self::LAYOUT_PATH . 'List', [
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        return view(self::LAYOUT_PATH . 'View')
            ->with('title', __(self::LANG_PATH . 'view'))
            ->with('data', $email);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        //
    }
}
