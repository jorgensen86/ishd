<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Settings\ConfigSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class QueueController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.setting.queue';
    const LANG_PATH = 'admin/setting/queue.';
    const PAGE_CLASS = 'queuePage';
    const COLUMNS = [
        ['data' => 'id'],
        ['data' => 'name'],
        ['data' => 'active', 'className' => 'text-center', 'orderable' => false, 'searchable' => false],
        ['data' => 'created_at', 'className' => 'text-right', 'searchable' => false],
        ['data' => 'updated_at','searchable' => false],
        ['data' => 'action', 'className' => 'text-right', 'orderable' => false, 'searchable' => false],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, ConfigSettings $configSettings)
    {
        if (request()->ajax()) {
            return DataTables::eloquent(Queue::query())
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d/m/Y');
                })
                ->editColumn('updated_at', function ($data) {
                    return Carbon::parse($data->updated_at)->format('d/m/Y');
                })
                ->addColumn('action', function ($data) {
                    return
                        '<button data-target="#queueModal" data-url="' . route('queue.edit', $data) . '" class="btn btn-outline-info btn-flat btn-sm btnOpenModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    <button data-target="#deleteModal" data-url="' . route('queue.destroy', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnDeleteModal">
                            <i class="fas fa-ban"></i>
                    </button>';
                })
                ->editColumn('active', function ($data) {
                    return $data->active ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-xmark"></i>';
                })
                ->rawColumns(['action', 'active'])
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
            Column::make()->title(__(self::LANG_PATH . 'active')),
            Column::make()->title(__(self::LANG_PATH . 'created')),
            Column::make()->title(__(self::LANG_PATH . 'updated')),
            Column::make()
        ]))
        ->with('columns', self::COLUMNS);
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
                ->with('queue', new Queue());
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
                ->with('queue', $queue);
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
