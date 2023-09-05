<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.setting.role';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render(self::LAYOUT_PATH . 'List', [
            'title' => __('role.title'),
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
                ->with('title', __('role.create'))
                ->with('action', route('role.store'))
                ->with('method', 'post')
                ->with('data', new Role());
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
                'success' =>  __('role.text_success'),
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
                ->with('title', __('role.edit'))
                ->with('action', route('role.update', $role))
                ->with('method', 'put')
                ->with('data', $role);
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
                'success' =>  __('role.text_success'),
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
        
        if($role->users()->count()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => array(sprintf(__('role.user_alert'), $role->users()->count()))
            );
        }
        
        if(!$json) {
            Role::find($role->id)->delete();
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('role.text_success'),
            );
        }
        
        return response()->json($json, 200);
    }
}
