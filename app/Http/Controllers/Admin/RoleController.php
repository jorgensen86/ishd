<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Settings\ConfigSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{

    const LAYOUT_PATH = 'layouts.admin.setting.role';
    const LANG_PATH = 'admin/setting/role.';
    const PAGE_CLASS = 'userPage';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, ConfigSettings $configSettings)
    {

        if (request()->ajax()) {
            return DataTables::eloquent(Role::query())
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d/m/Y');
                })
                ->editColumn('updated_at', function ($data) {
                    return Carbon::parse($data->updated_at)->format('d/m/Y');
                })
                ->addColumn('action', function ($data) {
                    return
                        '<button data-target="#roleModal" data-url="' . route('role.edit', $data) . '" class="btn btn-outline-info btn-flat btn-sm btnOpenModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    <button data-target="#deleteModal" data-url="' . route('role.destroy', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnDeleteModal">
                            <i class="fas fa-ban"></i>
                    </button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn('id')
                ->make(true);
        }


        return view(self::LAYOUT_PATH . 'List')
            ->with('results_per_page', $configSettings->results_per_page)
            ->with('class', self::PAGE_CLASS)
            ->with('title', __(self::LANG_PATH . 'title'))
            ->with('table',  $builder->columns([
                Column::make()->title(__(self::LANG_PATH . 'id')),
                Column::make()->title(__(self::LANG_PATH . 'name')),
                Column::make()->title(__(self::LANG_PATH . 'created')),
                Column::make()->title(__(self::LANG_PATH . 'updated')),
                Column::make()
            ]))
            ->with('columns', [
                ['data' => 'id'],
                ['data' => 'name'],
                ['data' => 'created_at'],
                ['data' => 'updated_at'],
                ['data' => 'action', 'className' => 'text-right', 'orderable' => false],
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
                ->with('action', route('role.store'))
                ->with('method', 'post')
                ->with('role', new Role());
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
            'name' => 'required|unique:roles',
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            Role::create([
                'name' => $request->name
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (request()->ajax()) {

            return view(self::LAYOUT_PATH . 'Form')
                ->with('title', __(self::LANG_PATH . 'edit'))
                ->with('action', route('role.update', $role))
                ->with('method', 'put')
                ->with('role', $role);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $json = [];

        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('roles', 'name')->ignore($role->id, 'id')],
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
            
        } else {
            $role->name = $request->name;
            $role->touch();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $json = [];
        
        if(User::role($role->name)->count()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => __('user.error_delete')
            );
        }
        
        if(!$json) {
            Role::find($role->id)->delete();
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('user.text_success'),
            );
        }
        
        return response()->json($json, 200);
    }
}
