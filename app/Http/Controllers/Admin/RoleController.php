<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings\ConfigSettings;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class RoleController extends Controller
{

    const LAYOUT_PATH = 'layouts.admin.setting.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, ConfigSettings $configSettings)
    {

        if (request()->ajax()) {
            return DataTables::eloquent(Role::query())
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

        $builder->columns([]);

        return view(self::LAYOUT_PATH . 'roleList')
        ->with('results_per_page', $configSettings->results_per_page)
        ->with('class' ,'user-page')
        ->with('title' , __('user.title_user'))
        ->with('table',  $builder->columns([
            Column::make(['title' => __('user.fullname')]),
            Column::make(['title' => __('user.email')]),
            Column::make(['title' => __('user.username')]),
            Column::make(['title' => __('user.active')]),
            Column::make(),
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
