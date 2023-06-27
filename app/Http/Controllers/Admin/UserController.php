<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;



class UserController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.user.user';
    const LANG_PATH = 'admin/user/user.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // $this->middleware('permission:view_users', ['only' => ['index']]);
        // $this->middleware('permission:edit_users', ['only' => ['edit','update', 'create', 'store']]);
        // $this->middleware('permission:delete_users', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $userDataTable)
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
            return view('layouts.admin.user.userForm')
                ->with('title', __('user.create_user'))
                ->with('action', route('user.store'))
                ->with('method', 'post')
                ->with('user', new User())
                ->with('roles', Role::all());
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
            'role' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            $user = User::create([
                'administrator' => 1,
                'email' => $request->email,
                'name' => $request->name,
                'username' => $request->username,
                'active' => $request->active ?? 0,
                'password' => Hash::make($request->password)
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (request()->ajax()) {
            return view('layouts.admin.user.userForm')
                ->with('title', __('user.edit_user'))
                ->with('action', route('user.update', $user))
                ->with('method', 'put')
                ->with('user', $user)
                ->with('roles', Role::all());
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
        $json = [];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role' => 'required',
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')],
            'email' => ['required', 'email',  Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'password' => $request->password ? 'min:8' : ''
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
            
        } else {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->active = $request->active ?? 0;
            if ($request->password) $user->password = Hash::make($request->password);

            $user->save();
            
            $user->syncRoles($request->role);

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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $json = [];

        if($user->user_id === auth()->user()->user_id) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => __('user.error_delete')
            );
        }
        
        if(!$json) {
            User::find($user->user_id)->delete();
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('user.text_success'),
            );
        }
        return response()->json($json, 200);
    }
}
