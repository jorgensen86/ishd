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
                    {{ $dataTable->table() }}
                </div>
            </div>

        </div>
        <x-admin.form-modal id="clientModal" size="md" :title="__('client.edit_client')"></x-admin.form-modal>
        <x-admin.delete-modal id="deleteModal" size="sm" :title="__('client.delete')"></x-admin.delete-modal>
    </section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}

<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" defer></script>
<script src="{{ asset('assets/plugins/select2/js/el.js') }}" defer></script>

<script type="module">
    $('#invoices').select2({
        placeholder: "Αναζήτηση με crm ή domain",
        width: '100%',
        theme: "classic",
        minimumInputLength: 3,
        language: "el",
        allowClear: true,
        ajax: {
            url: "{{ route('invoice.index') }}",
            dataType: "json",
            delay: 600,
            data: (params) => {
                return {
                    filter_invoice: params.term,
                };
            },
            processResults: function (json) {
                return {
                    results: $.map(json, function (item) {
                        return {
                            text: `${item.invoice_number}  ${item.user.name}`,
                            id: item.invoice_id
                        }
                    })
                };
            },
        },
    });
</script>
@endpush
