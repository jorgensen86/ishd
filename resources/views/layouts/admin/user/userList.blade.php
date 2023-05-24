@extends('admin')

@section('content')
    <x-admin.page-header :heading="__('sidebar.user_list')"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <button data-url="{{ route('user.create') }}" data-modal="user-modal"
                            class="btn btn-sm btn-info btn-open-modal">{{ __('el.button_add') }}</button>
                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    {{ $table->table() }}
                </div>
            </div>

        </div>
        <x-admin.form-modal id="user-modal" size="md" :title="__('user.edit_user')"></x-admin.form-modal>
        <x-admin.delete-modal id="delete-modal" size="sm" :title="__('user.delete')"></x-admin.delete-modal>
    </section>
@endsection

@push('scripts')
<script type="module">    
    $(function () {
        var table = $('#dataTableBuilder').DataTable(
            $.extend(
                $.DTABLE_CONFIG,
                {
                    ajax: "{{ route('user.index') }}",
                    columns: [
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'username' },
                        { data: 'active', className: 'text-center', orderable: false, searchable: false},
                        { data: 'action', className: 'text-right', orderable: false, searchable: false},

                    ]
                }
            )
        );

        $(document).on('click', '#buttonSave', function () {
            $('form input').removeClass('is-invalid')
            $.ajax({
                type: $('#user-modal form').attr('method'),
                data: $('#user-modal form').serialize(),
                url: $('#user-modal form').attr('action'),
                beforeSend: () => {
                    $('#user-modal button').prop('disabled', true)
                },
                complete: () => {
                    $('#user-modal button').prop('disabled', false)
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
                            delay: 4000,
                        })

                    } else {
                        $('#user-modal').modal('hide');
                        table.ajax.reload(null, false);
                    }
                }
            })
        })

    });
</script>
@endpush
