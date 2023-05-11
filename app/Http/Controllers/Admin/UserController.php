<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['class'] = 'user-page';
        $data['heading_title'] = 'Users';
        $data['breadcrumbs'][] = array(
            'name' => 'Home',
            'href' => route('dashboard')
        );

        $data['breadcrumbs'][] = array(
            'name' => 'User',
            'href' => route('user.index')
        );
        $data['users'] =  User::where('administrator', 1)->get();
        $data['add_action'] = route('user.create');
        // if (request()->ajax()) {
        //     return [ 'users' => User::all()];
        // }
        return view('layouts.admin.user.userList', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()) {
            return view('layouts.admin.user.userForm')
                ->with('action', route('user.store'))
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'errors' => $validator->getMessageBag()->toArray()
            ), 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(request()->ajax()) {
            return view('layouts.admin.user.userForm')
                ->with('action', route('user.update', $user))
                ->with('method', 'put')
                ->with('user', $user);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => ['required', Rule::unique('users','username')->ignore( $user->user_id, 'user_id')],
            'email' => ['required', 'email',  Rule::unique('users','email')->ignore( $user->user_id, 'user_id')],
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'errors' => $validator->getMessageBag()->toArray()
            ), 200);
        } else {

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
