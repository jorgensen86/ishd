<?php

namespace App\DataTables\Client;

use App\Http\Controllers\Admin\TicketController;
use App\Models\Ticket;
use App\Settings\ConfigSettings;
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
        $query->where('author_id', auth()->user()->user_id);

        if(request()->has('closed')) {
            $query->where('is_closed', 1);
        } else {
            $query->where('is_closed', 0);
        }

        if(request()->invoice) {
            $query->whereHas('invoice', function ($query) { 
                $query->where('invoice_number', request()->invoice); 
            });
        }

        if(request()->subject) {
            $query->where('subject', 'LIKE', request()->subject . '%');
        }

        if(request()->sender) {
            $query->whereHas('user', function ($query) { 
                $query->where('name', 'like', request()->sender. '%'); 
            });
        }

        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                return
                    '<a href="' . route('client.ticket.show', $data) . '" class="btn btn-outline-info btn-flat btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <button data-target="#deleteModal" data-url="' . route('queue.destroy', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnDeleteModal">
                            <i class="fas fa-ban"></i>
                    </button>';
            })
            ->setRowClass(function ($data) {
                return !$data->is_opened ? 'font-weight-bold' : null;
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
        ->ajax([
            'data' => 'function(params) { 
                params.invoice = $("#invoice").val() 
                params.subject = $("#subject").val() 
                params.sender = $("#sender").val() 
                
            }',
        ])
        ->parameters(array_merge(config('datatables.parameters'), $this->parameters()))
        ->setTableId('ticketTable')
        ->columns($this->getColumns())
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
            Column::make('ticket_id')->title(Lang::get(TicketController::LANG_PATH . 'ticket_id')),
            Column::make('invoice.invoice_number')->title(Lang::get(TicketController::LANG_PATH . 'invoice')),
            Column::make('user.name')->title(Lang::get(TicketController::LANG_PATH . 'sender')),
            Column::make('subject')->title(Lang::get(TicketController::LANG_PATH . 'subject')),
            Column::make('created_at')->title(Lang::get(TicketController::LANG_PATH . 'created'))->className('text-right'),
            Column::make('action')->title('')->searchable(false)->orderable(false)->className('text-right'),
        ];
    }

    public function parameters() {
        return [
            'pageLength' => app(ConfigSettings::class)->results_per_page,
            'stateSave' => true
        ];
    }
}