<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDataTable;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.user.client';
    const LANG_PATH = 'admin/user/client.';
    const PAGE_CLASS = 'clientPage';

    public function index(ClientDataTable $userDataTable)
    {        
        return $userDataTable->render(self::LAYOUT_PATH . 'List', [
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
                ->with('action', route('client.store'))
                ->with('method', 'post')
                ->with('data', new User());
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
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            $client = User::create([
                'administrator' => 0,
                'email' => $request->email,
                'name' => $request->name,
                'username' => $request->username,
                'active' => $request->active ?? 0,
                'password' => Hash::make($request->password)
            ]);

            if ($request->invoice) {
                foreach ($request->invoice as $invoice) {
                    Invoice::find($invoice)->user()->associate($client)->save();
                }
            }
            
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('client.text_success'),
            );
        }

        return response()->json($json, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client)
    {
        if (request()->ajax()) {
            return view(self::LAYOUT_PATH . 'Form')
                ->with('title', __(self::LANG_PATH . 'edit'))
                ->with('action', route('client.update', $client))
                ->with('method', 'put')
                ->with('data', $client)
                ->with('invoices', $client->invoices);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $client)
    {
        $json = [];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => ['required', Rule::unique('users', 'username')->ignore($client->user_id, 'user_id')],
            'email' => ['required', 'email',  Rule::unique('users', 'email')->ignore($client->user_id, 'user_id')],
            'password' => $request->password ? 'min:8' : ''
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            $client->name = $request->name;
            $client->username = $request->username;
            $client->email = $request->email;
            $client->active = $request->active ?? 0;
            if ($request->password) $client->password = Hash::make($request->password);

            $client->save();

            Invoice::where('user_id', $client->user_id)->update(['user_id' => null]);

            if ($request->invoice) {
                foreach ($request->invoice as $invoice) {
                    Invoice::find($invoice)->user()->associate($client)->save();
                }
            }

             $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('client.text_success'),
            );
        }

        return response()->json($json, 200);
    }

    public function destroy(User $client)
    {
        $json = [];

        if ($client->invoices()->count()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => __('client.error_invoice')
            );
        }

        if (!$json) {
            User::find($client->user_id)->delete();
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('client.text_success'),
            );
        }

        return response()->json($json, 200);
    }
}
