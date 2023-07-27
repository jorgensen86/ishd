<?php

namespace App\DataTables;

use App\Http\Controllers\Admin\UserController;
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
                return
                    '<button data-target="#userModal" data-url="' . route('user.edit', $data) . '" class="btn btn-outline-info btn-flat btn-sm btnOpenModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button data-target="#deleteModal" data-url="' . route('user.destroy', $data) . '" class="btn btn-danger btn-flat btn-sm btnDeleteModal">
                        <i class="fas fa-trash"></i>
                    </button>';
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
            ->ajax([
                'data' => 'function(d) { d.is_closed = $("#test").is(\':checked\') ? 1 : 0 }',
            ])
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
            Column::make('name')->title(__(UserController::LANG_PATH . 'fullname')),
            Column::make('email')->title(__(UserController::LANG_PATH . 'email')),
            Column::make('username')->title(__(UserController::LANG_PATH . 'username')),
            Column::computed('active')->title(__(UserController::LANG_PATH . 'active'))->className('text-center'),
            Column::computed('created_at')->title(__(UserController::LANG_PATH . 'created')),
            Column::computed('updated_at')->title(__(UserController::LANG_PATH . 'updated')),
            Column::computed('action')->title('')->className('text-right'),
        ];
    }

    public function parameters() {
        return [
            'pageLength' => app(ConfigSettings::class)->results_per_page,
            'stateSave' => true ,
        ];
    }
}
