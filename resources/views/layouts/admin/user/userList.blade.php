@extends('admin')

@section('content')
<x-admin.content-header :headingTitle="$heading_title" :breadcrumbs="$breadcrumbs"></x-admin.content-header>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button data-url="{{ $add_action }}" data-modal="user-modal" class="btn btn-sm btn-primary btn-open-modal">{{ __('el.button_add' )}}</button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered data-table">
                    <thead>
                       <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Intro</th>
                       </tr>
                    </thead>
                    <tbody>
                    </tbody>
                 </table>
            </div>
        </div>

    </div>
    <x-admin.modal id="user-modal" size="lg" :title="''"></x-admin.modal>
</section>
@endsection

@section('scripts')

<script type="module">
      $(function () {
           var table = $('.data-table').DataTable({
               processing: true,
               serverSide: true,
               
               ajax: "http://127.0.0.1:8000/user/user",
               columns: [
                    {data: 'user_id', name: 'user_id'},
                   {data: 'name', name: 'name'},
                   {data: 'email', name: 'email'},
                   {data: 'intro', name: 'intro'},
                   
               ]
           });
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