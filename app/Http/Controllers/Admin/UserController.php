<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Settings\ConfigSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Builder;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, ConfigSettings $configSettings)
    {
        
        if (request()->ajax()) {
            return Datatables::eloquent(User::where('administrator', 1))
                ->editColumn('active', function ($data) {
                    return $data->active ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-xmark"></i>';
                })
                ->addColumn('action', function ($data) {
                    return 
                    '<button data-target="#userModal" data-url="' . route('user.edit', $data) . '" class="btn btn-outline-info btn-flat btn-sm btnOpenModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    <button data-target="#deleteModal" data-url="' . route('user.destroy', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnDeleteModal">
                            <i class="fas fa-ban"></i>
                    </button>';
                })
                ->rawColumns(['action', 'active'])
                ->addIndexColumn()
                ->make(true);
        }

        $table = $builder->columns([
            Column::make(['title' => __('user.fullname')]),
            Column::make(['title' => __('user.email')]),
            Column::make(['title' => __('user.username')]),
            Column::make(['title' => __('user.active')]),
            Column::make(),
        ]);


        return view('layouts.admin.user.userList')
            ->with('results_per_page', $configSettings->results_per_page)
            ->with('class' ,'user-page')
            ->with('title' , __('user.title_user'))
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
            return view('layouts.admin.user.userForm')
                ->with('title', __('user.create_user'))
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
        $json = [];
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
        $json = [];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
