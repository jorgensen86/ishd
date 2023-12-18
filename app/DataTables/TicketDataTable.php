<?php

namespace App\DataTables;

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
        if(request()->has('queue_id')) {
            $query->where('queue_id' , request()->input('queue_id'));
        }
        
        if(request()->is_closed) {
            $query->where('is_closed' ,1);
        }

        if(request()->ticket_id) {
            $query->where('ticket_id', request()->ticket_id );
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
                    '<a href="' . route('ticket.show',  ['ticket' => $data, 'queue_id' => request()->input('queue_id')]) . '" class="btn">
                        <i class="fas fa-pencil"></i></a>
                    <button data-target="#deleteModal" data-url="' . route('queue.destroy', $data) . '" class="btn btn-danger btn-sm btnDeleteModal">
                            <i class="fas fa-xmark"></i>
                    </button>';
            })
            ->editColumn('ticket_id', function ($data) {
                return '<a href="' . route('ticket.show',  ['ticket' => $data, 'queue_id' => request()->input('queue_id')]) . '">' . $data->ticket_id . '</a>';
            })
            ->setRowClass(function ($data) {
                return !$data->is_opened ? 'font-weight-bold' : null;
            })
            ->rawColumns(['ticket_id', 'action'])
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
                params.ticket_id = $("#ticket_id").val()
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
        ];
    }
}