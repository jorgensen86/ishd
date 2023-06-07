@extends('admin')

@section('content')
<x-admin.page-header :heading="$title"></x-admin.page-header>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button data-url="{{ route('ticket.create') }}" data-target="#ticketModal"
                        class="btn btn-sm btn-info btnOpenModal">{{ __('el.button_add') }}</button>
                </div>
            </div>
            <div class="card-body table-responsive p-3">
                {{ $table->table() }}
            </div>
        </div>

    </div>
    <x-admin.form-modal id="ticketModal" size="md" :title="__('client.edit_title')"></x-admin.form-modal>
    <x-admin.delete-modal id="deleteModal" size="sm" :title="__('ticket.delete_title')"></x-admin.delete-modal>
</section>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        const table = $('#dataTableBuilder').DataTable(
            $.extend(
                $.DTABLE_CONFIG,
                {
                    stateSave: true,
                    stateSaveCallback: function (settings, data) {
                        localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
                    },
                    stateLoadCallback: function (settings) {
                        return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
                    },
                    ajax: "{{ route('ticket.index') }}",
                    columns: @json($columns),
                }
            )
        );
    });
</script>
@endpush