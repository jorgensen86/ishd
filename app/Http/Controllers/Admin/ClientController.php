<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index() {
        return view('layouts.admin.user.clientList', ['class'=> 'user', 'users' =>  User::with('clientInfo')->where('administrator', 0)->get()]);
    }
}
