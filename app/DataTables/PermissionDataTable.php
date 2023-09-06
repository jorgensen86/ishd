<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Settings\ConfigSettings;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PermissionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                return
                    ' <button data-target="#permissionModal" data-url="' . route('permission.edit', $data) . '" class="btn btn-default btn-sm btnOpenModal">
                    <i class="fas fa-pencil"></i>
                    </button>
                    <button data-target="#deleteModal" data-url="' . route('permission.destroy', $data) . '" class="btn btn-danger btn-flat btn-sm btnDeleteModal">
                            <i class="fas fa-xmark"></i>
                    </button>';
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d/m/Y');
            })
            ->editColumn('updated_at', function ($data) {
                return Carbon::parse($data->updated_at)->format('d/m/Y');
            })
            ->rawColumns(['active', 'action'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Permission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Permission $model): QueryBuilder
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
            ->setTableId('permissionTable')
            ->columns($this->getColumns())
            ->parameters(array_merge(config('datatables.parameters'), $this->parameters()))
            ->minifiedAjax()
            ->dom('rtip')
            ->orderBy(1, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title(__('permission.name')),
            Column::make('created_at')->title(__('el.created'))->className('text-right'),
            Column::make('updated_at')->title(__('el.updated'))->className('text-right'),
            Column::computed('action')->title('')->className('text-right'),
        ];
    }

    public function parameters()
    {
        return [
            'pageLength' => app(ConfigSettings::class)->results_per_page,
        ];
    }
}
