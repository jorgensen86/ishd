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
                <table class="table table-hover" id="users-table">
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
    <x-admin.modal id="user-modal" size="md" :type="'form'" :title="__('user.edit_user')"></x-admin.modal>
    <x-admin.modal id="delete-modal" size="sm" :type="'delete'" :title="__('user.delete')"></x-admin.modal>
</section>
@endsection

@push('scripts')

<script type="module">
    $(function () {
        var table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            ajax: "{{ route('user.index') }}",
            columns: [
                { data: 'user_id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'username' },
                { data: 'active', className: 'text-center' },
                { data: 'action', className: 'text-right' },

            ]
        });

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
                            delay: 2500,
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