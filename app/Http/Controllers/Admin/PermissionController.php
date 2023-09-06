<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    const LAYOUT_PATH = 'layouts.admin.setting.permission';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PermissionDataTable $permissionDataTable)
    {
        return $permissionDataTable->render(self::LAYOUT_PATH . 'List', [
            'title' => __('permission.title'),
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
                ->with('title', __('permission.create'))
                ->with('action', route('permission.store'))
                ->with('method', 'post')
                ->with('data', new Permission());
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
                'success' =>  __('permission.text_success'),
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
                ->with('title', __('permission.edit'))
                ->with('action', route('permission.update', $permission))
                ->with('method', 'put')
                ->with('data', $permission);
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
                'success' =>  __('permission.text_success'),
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
        
        if($permission->users()->count()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' =>  array(sprintf(__('permission.user_alert'), $permission->users()->count()))
            );
        }
        
        if(!$json) {
            Permission::findOrFail($permission->id)->delete();
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('permission.text_success'),
            );
        }
        
        return response()->json($json, 200);
    }
}
