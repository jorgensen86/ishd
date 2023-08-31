@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <nav class="navbar navbar-expand navbar-orange navbar-dark">
                <ul class="navbar-nav">
                    @foreach ($queues as $queue)
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="{{ route('ticket.index', $queue->id) }}"
                                class="nav-link{{ request()->route('queue_id') == $queue->id ? ' active' : null }}">{{ $queue->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('ticket.invoice') }}</label>
                                <input type="text" id="invoice" name="invoice" value="{{ $filter_invoice }}" class="form-control form-control-sm" placeholder="{{ __('ticket.invoice') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('ticket.sender') }}</label>
                                <input type="text" name="sender" id="sender" class="form-control form-control-sm" placeholder="{{ __('ticket.sender') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('ticket.subject') }}</label>
                                <input type="text" name="subject" id="subject" class="form-control form-control-sm" placeholder="{{ __('ticket.subject') }}">
                            </div>
                        </div>
                    </div>
                    <button type="button" id="filter_button" class="btn btn-info btn-sm"><i class="far fa-filter"></i></button>
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

    $("#filter_button").on('click', function(){
            $('#ticketTable').DataTable().ajax.reload();
    });
//     $('#ticketTable').on( 'click', 'tbody tr', function () {
//   window.location.href = $(this).data('link');
// });
    </script>
@endpush
