<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\QueueDataTable;
use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QueueController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.setting.queue';
    const LANG_PATH = 'admin/setting/queue.';
    const PAGE_CLASS = 'queuePage';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QueueDataTable $queueDataTable)
    {
        return $queueDataTable->render(self::LAYOUT_PATH . 'List', [
            'title' => __(self::LANG_PATH . 'title'),
            'queues' => Queue::all()
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
                ->with('action', route('queue.store'))
                ->with('method', 'post')
                ->with('data', new Queue());
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
            'name' => 'required|unique:queues',
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            Queue::create([
                'name' => $request->name,
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
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function edit(Queue $queue)
    {
        if (request()->ajax()) {
            return view(self::LAYOUT_PATH . 'Form')
                ->with('title', __(self::LANG_PATH . 'edit'))
                ->with('action', route('queue.update', $queue))
                ->with('method', 'put')
                ->with('data', $queue);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Queue $queue)
    {
        $json = [];

        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('queues', 'name')->ignore($queue->id, 'id')],
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
            
        } else {
            $queue->name = $request->name;
            $queue->active = $request->active ?? 0;
            $queue->touch();

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
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Queue $queue)
    {
        //
    }
}
