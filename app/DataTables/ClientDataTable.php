<?php

namespace App\DataTables;

use App\Http\Controllers\Admin\ClientController;
use App\Models\User;
use App\Settings\ConfigSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $query->whereNot('administrator', 1);

        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                return
                    '<button data-target="#clientModal" data-url="' . route('client.edit', $data) . '" class="btn btn-outline-info btn-flat btn-sm btnOpenModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button data-target="#deleteModal" data-url="' . route('client.destroy', $data) . '" class="btn btn-danger btn-flat btn-sm btnDeleteModal">
                        <i class="fas fa-trash"></i>
                    </button>';
            })
            ->addColumn('invoice', function (User $user) {
                return $user->invoices->map(function ($invoice) {
                    return "<span class='badge badge-danger'>{$invoice->invoice_number}</span>";
                })
                ->implode(' ');
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
            ->rawColumns(['invoice', 'action', 'active'])
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
            Column::make('name')->title(__(ClientController::LANG_PATH . 'fullname')),
            Column::make('username')->title(__(ClientController::LANG_PATH . 'username')),
            Column::make('email')->title(__(ClientController::LANG_PATH . 'email')),
            Column::make('invoice')->title(__(ClientController::LANG_PATH . 'invoice')),
            Column::computed('active')->title(__(ClientController::LANG_PATH . 'active'))->className('text-center'),
            Column::computed('created_at')->title(__(ClientController::LANG_PATH . 'created')),
            Column::computed('updated_at')->title(__(ClientController::LANG_PATH . 'updated')),
            Column::computed('action')->title('')->className('text-right'),
        ];
    }

    public function parameters() {
        return [
            'pageLength' => app(ConfigSettings::class)->results_per_page,
            'stateSave' => true
        ];
    }
}
