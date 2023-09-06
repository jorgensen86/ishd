<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\QueueDataTable;
use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QueueController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.setting.queue';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QueueDataTable $queueDataTable)
    {
        return $queueDataTable->render(self::LAYOUT_PATH . 'List', [
            'title' => __('queue.title'),
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
                ->with('title', __('queue.create'))
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
                'success' => __('queue.text_success'),
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
                ->with('title', __('queue.edit'))
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
                'success' => __('queue.text_success'),
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
        $json = [];

        if($queue->subjects->count()) {
            $json['errors'][] = sprintf(__('queue.subject_alert'), $queue->subjects->count());
        }

        if($queue->tickets->count()) {
            $json['errors'][] = sprintf(__('queue.ticket_alert'), $queue->tickets->count());
        }

        if($json) {
            $json['title'] = __('el.text_danger');
        } else {
            
            Queue::findOrFail($queue->id)->delete();
            
            $json = array(
                'title' => __('el.text_success'),
                'success' =>  __('queue.text_success'),
            );
        }

        return response()->json($json, 200);
    }
}
