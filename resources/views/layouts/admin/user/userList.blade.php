@extends('admin')

@section('content')
<x-admin.content-header :headingTitle="$heading_title" :breadcrumbs="$breadcrumbs"></x-admin.content-header>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button data-url="{{ $add_action }}" class="btn btn-primary btn-open-modal">dsd</button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="example">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->user_id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="tag tag-success">Approved</span></td>
                            <td>
                                <button data-url="{{ route('user.edit', $user) }}" class="btn btn-default btn-open-modal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <x-admin.modal id="user-modal"></x-admin.modal>
</section>
@endsection

@section('scripts')
<script type="module">
    $(document).on('click', '#buttonSave', function () {
        $('form input').removeClass('is-invalid')
        $.ajax({
            type: $('#user-modal form').attr('method'),
            data: $('#user-modal form').serialize(),
            url: $('#user-modal form').attr('action'),
            beforeSend: () => {
                $('#user-modal button').prop('disabled', true)
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
                }
            }
        })
    })

    $(document).ready(function () {
        // $('#example').DataTable( {
        //     searchDelay: 2000,
        //     search: true,
        //     columnDefs: [
        //         { targets: 0, orderable: false },
        //         { targets: 1, orderable: false },
        //         { targets: 4, orderable: false },

        //     ],
        //     processing: true,
        //     serverSide: true,
        //     searchDelay: 350,
        //     ajax: {
        //         url: "http://127.0.0.1:8000/users",
        //         data: function ( params ) {
        //         console.log(params);
        //         }
        //     },
        // });
        // console.log($('#example'));
    });
</script>
@endsection