<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index() { 
        $data['class'] = 'client-page';
        if (request()->ajax()) {
            return DataTables::eloquent(User::with('invoices')->where('users.administrator', 0))
            ->addColumn('invoices', function (User $user) {
                return $user->invoices->map(function($invoice) {
                    return "<span class='badge badge-danger'>{$invoice->invoice_number}</span>";
                })
                ->implode(' ');
            })
            ->addColumn('domain', function (User $user) {
                return collect($user->invoices)->map(function($invoice) {
                    return $invoice->domain ? "<a href='http://{$invoice->domain}' target='_blank'>{$invoice->domain}</a>" : null;
                })
                ->reject(function ($invoice) {
                    return empty($invoice);
                })
                ->implode(', ');
            })
            ->editColumn('active', function ($data) {
                return $data->active ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-ban"></i>';
            })
            ->rawColumns(['domain', 'active', 'invoices'])
            ->toJson();
        }

        return view('layouts.admin.user.clientList', $data);
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
                ->with('action', route('client.store'))
                ->with('method', 'post')
                ->with('user', new User());
        }
    }
}
