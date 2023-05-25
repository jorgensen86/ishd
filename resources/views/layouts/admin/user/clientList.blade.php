@extends('admin')

@section('content')
<x-admin.page-header :heading="__('sidebar.client_list')"></x-admin.page-header>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button data-url="{{ route('client.create') }}" data-target="#clientModal"
                        class="btn btn-sm btn-info btnOpenModal">{{ __('el.button_add') }}</button>
                </div>
            </div>
            <div class="card-body table-responsive p-3">
                {{ $table->table() }}
            </div>
        </div>

    </div>
    <x-admin.form-modal id="clientModal" size="md" :title="__('client.edit_title')"></x-admin.form-modal>
    <x-admin.delete-modal id="deleteModal" size="sm" :title="__('client.delete_title')"></x-admin.delete-modal>
</section>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        const table = $('#dataTableBuilder').DataTable(
            $.extend(
                $.DTABLE_CONFIG,
                {
                    ajax: "{{ route('client.index') }}",
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'username', name: 'username' },
                        { data: 'invoices', name: 'invoices.invoice_number', orderable: false },
                        { data: 'domain', name: 'invoices.domain', orderable: false },
                        { data: 'active', name: 'active', className: 'text-center', searchable: false, orderable: false },
                        { data: 'action', name: 'active', className: 'text-center', searchable: false, orderable: false },
                    ],
                }
            )
        );
    });
</script>
@endpush