<?php

namespace App\DataTables;

use App\Models\Queue;
use App\Settings\ConfigSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class QueueDataTable extends DataTable
{
    const LANG_PATH = 'admin/setting/queue.';

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
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
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Queue $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Queue $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('queueTable')
            ->columns($this->getColumns())
            ->parameters(array_merge(config('datatables.parameters'), $this->parameters()))
            ->minifiedAjax()
            ->dom('rtip')
            ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name')->title(Lang::get(self::LANG_PATH . 'name')),
            Column::make('active')->title(Lang::get(self::LANG_PATH . 'active'))->searchable(false)->orderable(false)->className('text-center'),
            Column::make('created_at')->title(Lang::get(self::LANG_PATH . 'created'))->className('text-right'),
            Column::make('updated_at')->title(Lang::get(self::LANG_PATH . 'updated'))->className('text-right'),
            Column::make('action')->title('')->searchable(false)->orderable(false)->className('text-right'),
        ];
    }

    public function parameters()
    {
        return [
            'pageLength' => app(ConfigSettings::class)->results_per_page,
            'stateSave' => true
        ];
    }
}
