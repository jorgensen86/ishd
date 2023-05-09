@extends('admin')

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
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
                                            <td>{{ $user->clientInfo->invoice }}</td>
                                           
                                            <td><span class="tag tag-success">Approved</span></td>
                                            <td>
                                                <a href="{{ route('user.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script type="module">
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
