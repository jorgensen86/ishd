@extends('admin')

@section('content')
<x-admin.page-header :heading="__('sidebar.client_list')"></x-admin.page-header>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button data-url="{{ route('client.create') }}" data-modal="client-modal"
                        class="btn btn-sm btn-primary btn-open-modal">{{ __('el.button_add') }}</button>
                </div>
            </div>
            <div class="card-body table-responsive p-3">
                <table class="table table-hover client-datatable">
                    <thead>
                        <tr>
                            <th>{{ __('user.invoice') }}</th>
                            <th>{{ __('user.username') }}</th>
                            <th>{{ __('user.invoice') }}</th>
                            <th>{{ __('user.domain') }}</th>
                            <th>{{ __('user.active') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <x-admin.modal id="client-modal" size="md" :type="'form'" :title="__('user.edit_client')"></x-admin.modal>
    <x-admin.modal id="delete-modal" size="sm" :type="'delete'" :title="__('user.delete')"></x-admin.modal>
</section>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        const table = $('.client-datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            ajax: "{{ route('client.index') }}",
            searchDelay: 800,
            dom: 'frtip',
            columns: [
                { data: 'user_id', name: 'user_id' },
                { data: 'username', name: 'username' },
                { data: 'invoices', name: 'invoices.invoice_number', searchable: false, orderable: false },
                { data: 'domain', name: 'invoices.domain', searchable: false, orderable: false },
                { data: 'active', name: 'active', className: 'text-center', searchable: false, orderable: false },
                { data: 'action', name: 'active', className: 'text-center', searchable: false, orderable: false },
            ],
        });

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