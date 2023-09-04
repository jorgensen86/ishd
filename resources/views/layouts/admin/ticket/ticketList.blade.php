@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <nav class="navbar navbar-expand navbar-dark mb-2">
                <ul class="navbar-nav">
                    @foreach ($queues as $queue)
                        <li class="nav-item d-none d-sm-inline-block">
                            @can('view_queue_' . $queue->id)
                                <a href="{{ route('ticket.index', ['queue_id' => $queue->id]) }}"
                                    class="nav-link{{ request()->input('queue_id') == $queue->id ? ' active' : null }}">{{ $queue->name }} (<span>{{ $queue->tickets->count() }}</span>)</a> 
                            @endcan
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <x-admin.form.text name="ticket_id" id="ticket_id" :placeholder="__('ticket.ticket_id')"
                                :value="$filter_invoice"></x-admin.form.text>
                        </div>
                        <div class="col-md-3">
                            <x-admin.form.text name="invoice" id="invoice" :placeholder="__('ticket.invoice')"
                                :value="$filter_invoice"></x-admin.form.text>
                        </div>
                        <div class="col-md-3">
                            <x-admin.form.text name="sender" id="sender" :placeholder="__('ticket.sender')"
                                :value="$filter_invoice"></x-admin.form.text>
                        </div>
                        <div class="col-md-3">
                            <x-admin.form.text name="subject" id="subject" :placeholder="__('ticket.subject')"
                                :value="$filter_invoice"></x-admin.form.text>
                            <button type="button" id="filter_button" class="btn btn-info btn-sm"><i
                                    class="far fa-filter"></i></button>
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
        $("#test").on('change', function() {
            $('table').DataTable().draw();
        });

        $("#filter_button").on('click', function() {
            $('#ticketTable').DataTable().ajax.reload();
        });

        $("#ticket_id").on('input', function() {
            $('#ticketTable').DataTable().ajax.reload();
        });
        //     $('#ticketTable').on( 'click', 'tbody tr', function () {
        //   window.location.href = $(this).data('link');
        // });
    </script>
@endpush
