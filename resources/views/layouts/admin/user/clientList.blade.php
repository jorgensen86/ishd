@extends('admin')

@section('content')
<x-admin.page-header :heading="__('sidebar.client_list')"></x-admin.page-header>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button data-url="{{ route('client.create') }}" data-modal="client-modal"
                        class="btn btn-sm btn-info btn-open-modal">{{ __('el.button_add') }}</button>
                </div>
            </div>
            <div class="card-body table-responsive p-3">
                {{ $table->table() }}
            </div>
        </div>

    </div>
    <x-admin.form-modal id="client-modal" size="md" :title="__('client.edit_title')"></x-admin.form-modal>
    <x-admin.delete-modal id="delete-modal" size="sm" :title="__('client.delete_title')"></x-admin.delete-modal>
</section>
@endsection

@push('scripts')
<script type="module">
    import datatablesConfig from "{{ Vite::asset('resources/js/config/datatables.js') }}" 
    
    $(function () {
        const table = $('#dataTableBuilder').DataTable(
            $.extend(
                datatablesConfig,
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

        $(document).on('click', '#buttonSave', function () {
            $('form input').removeClass('is-invalid')
            $.ajax({
                type: $('#client-modal form').attr('method'),
                data: $('#client-modal form').serialize(),
                url: $('#client-modal form').attr('action'),
                beforeSend: () => {
                    $('#client-modal button').prop('disabled', true)
                },
                complete: () => {
                    $('#client-modal button').prop('disabled', false)
                },
                success: (json) => {
                    if (json.errors) {
                        let errors = '';
                        Object.keys(json.errors).forEach(function (key) {
                            $('input[name="' + key + '"]').addClass('is-invalid')
                            errors += json.errors[key] + "<br>";
                        });
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Προσοχή',
                            body: errors,
                            autohide: true,
                            delay: 2500,
                        })

                    } else {
                        $('#client-modal').modal('hide');
                        table.ajax.reload(null, false);
                    }
                }
            })
        })

    });
</script>
@endpush