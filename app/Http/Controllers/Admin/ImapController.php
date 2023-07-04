<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ImapDataTable;
use App\Http\Controllers\Controller;
use App\Models\Imap;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ImapController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.email.imap';
    const LANG_PATH = 'admin/email/imap.';
    const PAGE_CLASS = 'imapPage';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ImapDataTable $imapDataTable)
    {
        return $imapDataTable->render(self::LAYOUT_PATH . 'List', [
            'title' => __(self::LANG_PATH . 'title'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            return view(self::LAYOUT_PATH . 'Form')
                ->with('title', __(self::LANG_PATH . 'create'))
                ->with('action', route('imap.store'))
                ->with('method', 'post')
                ->with('queues', Queue::where('active', 1)->get())
                ->with('data', new Imap());
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
        $json = [];
        
        $validator = Validator::make($request->all(), [
            'host' => 'required',
            'username' => 'required|unique:imaps|email',
            'port' => 'required|digits_between:1,3',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            
            Imap::create([
                'host' =>  $request->host,
                'username' => $request->username,
                'password' => $request->password,
                'port' => $request->port,
                'queue_id' => $request->queue_id,
                'encryption' => $request->encryption,
                'validate_cert' => $request->validate_cert,
                'active' => $request->active ?? 0,
            ]);

            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('user.text_success'),
            );
        }

        return response()->json($json, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Imap  $imap
     * @return \Illuminate\Http\Response
     */
    public function edit(Imap $imap)
    {
        if (request()->ajax()) {
            return view(self::LAYOUT_PATH . 'Form')
                ->with('title', __(self::LANG_PATH . 'edit'))
                ->with('action', route('imap.update', $imap))
                ->with('method', 'put')
                ->with('data', $imap)
                ->with('queues', Queue::where('active', 1)->get());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Imap  $imap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Imap $imap)
    {
        $json = [];

        $validator = Validator::make($request->all(), [
            'host' => 'required',
            'username' => ['required', Rule::unique('imaps', 'username')->ignore($imap->id, 'id')],
            'port' => 'required|digits_between:1,3',
            'password' => $request->password ? 'min:1' : ''
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
            
        } else {
            $imap->host = $request->host;
            $imap->queue_id = $request->queue_id;
            $imap->encryption = $request->encryption;
            $imap->validate_cert = $request->validate_cert;
            $imap->username = $request->username;
            $imap->active = $request->active ?? 0;
            
            if ($request->password) $imap->password = $request->password;

            $imap->touch();
            
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('user.text_success'),
            );
        }

        return response()->json($json, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Imap  $imap
     * @return \Illuminate\Http\Response
     */
    public function destroy(Imap $imap)
    {
        //
    }
}
