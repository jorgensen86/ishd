<?php

namespace App\DataTables;

use App\Models\User;
use App\Settings\ConfigSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $query->where('administrator', 1);

        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                $html = '';
                if (auth()->user()->hasPermissionTo('edit_users')) {
                    $html .= '<button data-target="#userModal" data-url="' . route('user.edit', $data) . '" class="btn btn-default btn-sm btnOpenModal"><i class="fas fa-pencil"></i></button>';
                }

                if (auth()->user()->hasPermissionTo('delete_users')) {
                    $html .= '<button data-target="#deleteModal" data-url="' . route('user.destroy', $data) . '" class="btn btn-danger btn-sm btnDeleteModal ml-1"><i class="fas fa-xmark"></i></button>';
                }
                return $html;
            })
            ->editColumn('active', function ($data) {
                return $data->active ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-xmark"></i>';
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d/m/Y');
            })
            ->editColumn('updated_at', function ($data) {
                return Carbon::parse($data->updated_at)->format('d/m/Y');
            })
            ->rawColumns(['action', 'active'])
            ->setRowId('user_id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
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
            ->parameters(array_merge(config('datatables.parameters'), $this->parameters()))
            ->setTableId('ticketTable')
            ->columns($this->getColumns())
            ->orderBy(0, 'asc')
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title(__('user.fullname')),
            Column::make('email')->title(__('user.email')),
            Column::make('username')->title(__('user.username')),
            Column::computed('active')->title(__('user.status'))->className('text-center'),
            Column::computed('created_at')->title(__('el.created'))->className('text-right'),
            Column::computed('updated_at')->title(__('el.updated'))->className('text-right'),
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
