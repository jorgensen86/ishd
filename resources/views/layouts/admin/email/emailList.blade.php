@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-lg-2">
                    <a href="compose.html" class="btn btn-primary btn-block mb-3">Compose</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Folders</h3>
                        </div>
                        <div class="card-body p-0" style="display: block;">
                            <ul class="nav nav-pills flex-column">
                                @foreach ($queues as $queue)
                                    <li
                                        class="nav-item {{ request()->input('queue_id') == $queue->id ? ' active' : null }}">
                                        <a href="{{ route('email.index', ['queue_id' => $queue->id]) }}" class="nav-link">
                                            {{ $queue->name }}
                                            <span class="badge bg-primary float-right">{{ $queue->emails->count() }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-md-9 col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Inbox</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Search Mail">
                                    <div class="input-group-append">
                                        <div class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="mailbox-controls">

                                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                        class="far fa-square"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>

                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <div class="float-right">
                                    1-50/200
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="table-responsive mailbox-messages p-2">
                                {{ $dataTable->table() }}
                            </div>

                        </div>

                        <div class="card-footer p-0">
                            <div class="mailbox-controls">

                                <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                                    <i class="far fa-square"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>

                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <div class="float-right">
                                    1-50/200
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="module">
        $("#filter_button").on('click', function() {
            $('#ticketTable').DataTable().ajax.reload();
        });
        //     $('#ticketTable').on( 'click', 'tbody tr', function () {
        //   window.location.href = $(this).data('link');
        // });
    </script>
@endpush
