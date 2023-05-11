@extends('admin')

@section('content')
    <x-admin.content-header :headingTitle="$heading_title" :breadcrumbs="$breadcrumbs"></x-admin.content-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <button data-url="{{ $add_action }}" class="btn btn-primary modalForm">dsd</button>
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
                                        <button data-url="{{ route('user.edit', $user) }}" class="btn btn-default modalForm">
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
        <x-admin.modal id="modal-default"></x-admin.modal>
    </section>
@endsection

@section('scripts')
    <script type="module">
        $('.modalForm').on('click', function() {
            $('#modal-default .modal-body').empty()
            $.ajax({
                type: 'get',
                url: $(this).data('url'),
                success: (html) => {
                    $('#modal-default .modal-body').append(html)
                    $('#modal-default').modal('show')
                }
            })
        })


        $(document).on('click', '#buttonSave', function() {
            $('form input').removeClass('is-invalid')
            $.ajax({
                type: $('#modal-default .modal-body form').attr('method'),
                data: $('#modal-default .modal-body form').serialize(),
                url: $('#modal-default .modal-body form').attr('action'),
                success: (json) => {
                    $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        icon: 'fas fa-envelope fa-lg',
      })
                    if(json.errors) {
                        Object.keys(json.errors).forEach(function(key) {
                            $('input[name="' + key +'"]').addClass('is-invalid')

console.log(key, json.errors[key]);

});
                    }
                }
            })
        })

    $(document).ready(function() {
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
