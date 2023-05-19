<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return Datatables::eloquent(User::where('administrator', 1))
                ->editColumn('active', function ($data) {
                    return $data->active ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-ban"></i>';
                })
                ->addColumn('action', function ($data) {
                    return '
                        <button data-modal="user-modal" data-url="' . route('user.edit', $data) . '" class="btn btn-outline-info btn-flat btn-sm btn-open-modal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button data-modal="delete-modal" data-url="' . route('user.destroy', $data) . '" class="btn btn-danger btn-flat btn-sm btn-delete-modal">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action', 'active'])
                ->addIndexColumn('user_id')
                ->make(true);
        }

        return view('layouts.admin.user.userList')
            ->with('class' ,'user-page')
            ->with('title' , trans('user.title_user'));
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
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'errors' => $validator->getMessageBag()->toArray()
            ), 200);
        } else {
            $user = User::create([
                'administrator' => 1,
                'email' => $request->email,
                'name' => $request->name,
                'username' => $request->username,
                'active' => $request->active ?? 0,
                'password' => Hash::make($request->password)
            ]);
        }
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
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')],
            'email' => ['required', 'email',  Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'password' => $request->password ? 'min:8' : ''
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'errors' => $validator->getMessageBag()->toArray()
            ), 200);
        } else {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->active = $request->active ?? 0;
            if ($request->password) $user->password = Hash::make($request->password);

            $user->save();
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
