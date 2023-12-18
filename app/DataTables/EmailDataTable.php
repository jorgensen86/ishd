<?php

namespace App\DataTables;

use App\Http\Controllers\Admin\TicketController;
use App\Models\Email;
use App\Settings\ConfigSettings;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Lang;

class EmailDataTable extends DataTable
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

        if(request()->invoice) {
            $query->where('invoice_number', request()->invoice);
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
                    '<button data-target="#deleteModal" data-url="' . route('queue.destroy', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnDeleteModal">
                            <i class="fas fa-ban"></i>
                    </button>';
            })
            ->setRowClass(function ($data) {
                // return !$data->is_opened ? 'font-weight-bold' : null;
            })
            ->addColumn('ticket_number', function ($data) {
                return '<a href="' . route('email.show',  ['email' => $data, 'queue_id' => request()->input('queue_id')]) . '">' . $data->ticket_number->id . '</a>';
            })
            ->rawColumns(['ticket_number','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Email $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Email $model): QueryBuilder
    {
        return $model->newQuery()->with('ticket_number')->select('emails.*');
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
        ->setTableId('emailTable')
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
            Column::make('ticket_number', 'ticket_number.id'),
            Column::make('sender')->title(Lang::get(TicketController::LANG_PATH . 'sender')),
            Column::make('subject')->title(Lang::get(TicketController::LANG_PATH . 'subject')),
            Column::make('sent_at')->title(Lang::get(TicketController::LANG_PATH . 'created'))->className('text-right'),
            Column::make('action')->title('')->searchable(false)->orderable(false)->className('text-right'),
        ];
    }

    public function parameters() {
        return [
            'pageLength' => app(ConfigSettings::class)->results_per_page,
        ];
    }
}