<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientInfo;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index() { 
        $data['class'] = 'client-page';
        $data['add_action'] = '';

        // if (request()->ajax()) {
        //     return Datatables::eloquent(User::with('clientInfo')->where('administrator', 0))
        //     ->addColumn('invoice', function (User $user) {
        //         return $user->clientInfo->map(function($cinfo) {
        //             return $cinfo->invoice;
        //         });
        //     })
        //     ->toJson();
        // }

        if (request()->ajax()) {
            $model = ClientInfo::join('users', 'client_infos.user_id', '=', 'users.user_id')->where('users.administrator', 0);
            return DataTables::eloquent($model)
            ->toJson();
        }

        return view('layouts.admin.user.clientList', $data);
    }
}
