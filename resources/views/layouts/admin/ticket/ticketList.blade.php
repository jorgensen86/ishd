@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <nav class="navbar navbar-expand navbar-orange navbar-dark">
                <ul class="navbar-nav">
                    @foreach ($queues as $queue)         
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="{{ route('ticket.index', $queue->id) }}" class="nav-link{{ request()->route('queue_id') == $queue->id ? ' active' : null }}">{{ $queue->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="card">
                <div class="card-header">
                    <input type="checkbox" name="is_closed" id="test" value="1">
                    <div class="float-right dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown button
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form action="" class="p-2">
                                <div class="form-group">
                                    <input type="text" class="form-control">
                                </div>
                                <select name="" id="">
                                    <option value=""></option>
                                </select>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="module">
        $("#test").on('change', function(){
            $('table').DataTable().draw();
    });
//     $('#ticketTable').on( 'click', 'tbody tr', function () {
//   window.location.href = $(this).data('link');
// });
    </script>
@endpush
