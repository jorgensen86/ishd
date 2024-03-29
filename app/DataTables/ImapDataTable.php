<?php

namespace App\DataTables;

use App\Http\Controllers\Admin\ImapController;
use App\Models\Imap;
use App\Settings\ConfigSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ImapDataTable extends DataTable
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
                    '<button ata-toggle="tooltip" title="Check Connection" data-url="' . route('checkConnection', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnCheckConnection">
                    <i class="fas fa-ban"></i>
                    </button>
                    <button data-target="#imapModal" data-url="' . route('imap.edit', $data) . '" class="btn btn-outline-info btn-flat btn-sm btnOpenModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button data-target="#deleteModal" data-url="' . route('imap.destroy', $data) . '" class="btn btn-outline-danger btn-flat btn-sm btnDeleteModal">
                            <i class="fas fa-ban"></i>
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
     * @param \App\Models\role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Imap $model): QueryBuilder
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
            ->setTableId('imapTable')
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
            Column::make('id')->title('ID'),
            Column::make('host')->title(__(ImapController::LANG_PATH . 'host')),
            Column::make('username')->title(__(ImapController::LANG_PATH . 'username')),
            Column::make('queue.name')->title(__(ImapController::LANG_PATH . 'queue')),
            Column::make('port')->title(__(ImapController::LANG_PATH . 'port')),
            Column::make('created_at')->title(__(ImapController::LANG_PATH . 'created'))->className('text-right'),
            Column::make('updated_at')->title(__(ImapController::LANG_PATH . 'updated'))->className('text-right'),
            Column::computed('action')->title('')->className('text-right'),
        ];
    }

    public function parameters()
    {
        return [
            'pageLength' => app(ConfigSettings::class)->results_per_page,
            'stateSave' => false,
            'drawCallback' => 'function() {
                $(".btnCheckConnection").tooltip();
                $(".btnCheckConnection").on("click", function() {
                    $(this).tooltip("hide");
                    $.ajax({
                        url: $(this).attr("data-url"),
                        dataType: "json",
                        beforeSend: function() {
                            $("#imapTable .btn").prop("disabled", true)
                        },
                        complete: function() {
                            $("#imapTable .btn").prop("disabled", false)
                        },
                        success: function(json) {
                            alert(json.message);
                        },
                        error: (xhr) => {
                            alert(xhr.status + " - " + xhr.responseJSON.message)
                        }
                    })
                });
             }',
        ];
    }
}
