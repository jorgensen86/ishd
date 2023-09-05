<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubjectDataTable;
use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.setting.subject';
    const LANG_PATH = 'subject.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubjectDataTable $subjectDataTable)
    {
        return $subjectDataTable->render(self::LAYOUT_PATH . 'List', [
            'title' => __(self::LANG_PATH . 'title'),
            'queues' => Subject::all()
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
                ->with('action', route('subject.store'))
                ->with('method', 'post')
                ->with('queues', Queue::where('active', 1)->get())
                ->with('data', new Subject());
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
            'name' => 'required|unique:subjects',
            'queue_id' => 'required',
        ], [
            'queue_id.required' => __(self::LANG_PATH . 'error_queue')
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {

            Subject::create([
                'name' => $request->name,
                'queue_id' => $request->queue_id,
                'active' => $request->active ?? 0
            ]);

            $json = array(
                'title' => __('el.text_success'),
                'success' => __(self::LANG_PATH . 'text_success'),
            );
        }

        return response()->json($json, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        if (request()->ajax()) {
            return view(self::LAYOUT_PATH . 'Form')
                ->with('title', __(self::LANG_PATH . 'edit'))
                ->with('action', route('subject.update', $subject))
                ->with('method', 'put')
                ->with('queues', Queue::where('active', 1)->get())
                ->with('data', $subject);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $json = [];

        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('roles', 'name')->ignore($subject->id, 'id')],
            'queue_id' => 'required'
        ], [
            'queue_id.required' => __(self::LANG_PATH . 'error_queue')
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
            
        } else {
            $subject->name = $request->name;
            $subject->queue_id = $request->queue_id;
            $subject->active = $request->active ?? 0;
            $subject->touch();

            $json = array(
                'title' => __('el.text_success'),
                'success' => __(self::LANG_PATH . 'text_success'),
            );
        }

        return response()->json($json, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $json = [];
        
        // if(User::role($role->name)->count()) {
        //     $json = array(
        //         'title' => __('el.text_danger'),
        //         'errors' => __('user.error_delete')
        //     );
        // }
        
        if(!$json) {
            Subject::find($subject->id)->delete();
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('user.text_success'),
            );
        }
        
        return response()->json($json, 200);
    }
}
