<?php

namespace App\DataTables;

use App\Http\Controllers\Admin\TicketController;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Lang;

class TicketDataTable extends DataTable
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
                    '<a href="' . route('ticket.show', $data) . '" class="btn btn-outline-info btn-flat btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button data-target="#deleteModal" data-url="' . route('queue.destroy', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnDeleteModal">
                            <i class="fas fa-ban"></i>
                    </button>';
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Ticket $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ticket $model): QueryBuilder
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
                    ->setTableId('ticketTable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(4,'asc')
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
            Column::make('id'),
            Column::make('invoice_number')->title(Lang::get(TicketController::LANG_PATH . 'invoice')),
            Column::make('user.name')->title(Lang::get(TicketController::LANG_PATH . 'from')),
            Column::make('subject')->title(Lang::get(TicketController::LANG_PATH . 'subject')),
            Column::make('created_at')->title(Lang::get(TicketController::LANG_PATH . 'created'))->className('text-right'),
            Column::make('action')->title('')->searchable(false)->orderable(false)->className('text-right'),
        ];
    }
}
