<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class ClientController extends Controller
{
    public function index(Builder $builder)
    {

        if (request()->ajax()) {
            return DataTables::eloquent(User::with('invoices')->where('users.administrator', 0))
                ->addColumn('invoices', function (User $user) {
                    return $user->invoices->map(function ($invoice) {
                        return "<span class='badge badge-danger'>{$invoice->invoice_number}</span>";
                    })
                        ->implode(' ');
                })
                ->addColumn('domain', function (User $user) {
                    return collect($user->invoices)->map(function ($invoice) {
                        return $invoice->domain ? "<a href='http://{$invoice->domain}' target='_blank'>{$invoice->domain}</a>" : null;
                    })
                        ->reject(function ($invoice) {
                            return empty($invoice);
                        })
                        ->implode(', ');
                })
                ->addColumn('action', function ($data) {
                    return '
                    <button data-target="#clientModal" data-url="' . route('client.edit', $data) . '" class="btn btn-outline-info btn-flat btn-sm btnOpenModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button data-target="#deleteModal" data-url="' . route('client.destroy', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnDeleteModal">
                        <i class="fas fa-ban"></i>
                    </button>';
                })
                ->editColumn('active', function ($data) {
                    return $data->active ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-xmark"></i>';
                })
                ->rawColumns(['domain', 'active', 'invoices', 'action'])
                ->toJson();
        }

        $table = $builder->columns([
            Column::make(['title' => __('client.fullname')]),
            Column::make(['title' => __('client.username')]),
            Column::make(['title' => __('client.invoice')]),
            Column::make(['title' => __('client.domain')]),
            Column::make(['title' => __('client.active')]),
            Column::make(),
        ]);

        return view('layouts.admin.user.clientList')
            ->with('class', 'client-page')
            ->with('title', __('client.title'))
            ->with('table', $table);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            return view('layouts.admin.user.clientForm')
                ->with('title', __('client.create_client'))
                ->with('action', route('client.store'))
                ->with('method', 'post')
                ->with('user', new User());
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
            return view('layouts.admin.user.clientForm')
                ->with('title', __('client.edit_client'))
                ->with('action', route('client.update', $client))
                ->with('method', 'put')
                ->with('user', $client)
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
