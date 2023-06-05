<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Settings\ConfigSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    const LAYOUT_PATH = 'layouts.admin.setting.permission';
    const LANG_PATH = 'admin/setting/permission.';
    const PAGE_CLASS = 'permPage';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, ConfigSettings $configSettings)
    {

        if (request()->ajax()) {
            return DataTables::eloquent(Permission::query())
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d/m/Y');
                })
                ->editColumn('updated_at', function ($data) {
                    return Carbon::parse($data->updated_at)->format('d/m/Y');
                })
                ->addColumn('action', function ($data) {
                    return
                        '<button data-target="#permissionModal" data-url="' . route('permission.edit', $data) . '" class="btn btn-outline-info btn-flat btn-sm btnOpenModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    <button data-target="#deleteModal" data-url="' . route('permission.destroy', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnDeleteModal">
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
                ->with('action', route('permission.store'))
                ->with('method', 'post')
                ->with('permission', new Permission());
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
            'name' => 'required|unique:permissions',
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            Permission::create([
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
    public function edit(Permission $permission)
    {
        if (request()->ajax()) {

            return view(self::LAYOUT_PATH . 'Form')
                ->with('title', __(self::LANG_PATH . 'edit'))
                ->with('action', route('permission.update', $permission))
                ->with('method', 'put')
                ->with('permission', $permission);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $json = [];

        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('permissions', 'name')->ignore($permission->id, 'id')],
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
            
        } else {
            $permission->name = $request->name;
            $permission->touch();

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
    public function destroy(Permission $permission)
    {
        $json = [];
        
        // if(User::role($role->name)->count()) {
        //     $json = array(
        //         'title' => __('el.text_danger'),
        //         'errors' => __('user.error_delete')
        //     );
        // }
        
        if(!$json) {
            Permission::find($permission->id)->delete();
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('user.text_success'),
            );
        }
        
        return response()->json($json, 200);
    }
}
