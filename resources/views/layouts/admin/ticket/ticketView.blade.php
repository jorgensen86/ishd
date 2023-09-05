@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="overlay-wrapper">
            <x-form.overlay></x-form.overlay>
            <div class="container-fluid">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                {{-- Reply Form --}}
                <form action="{{ route('reply.store') }}" method="post" id="replyForm">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        @csrf
                                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                        <input type="hidden" name="author_id" value="{{ auth()->user()->user_id }}">
                                        <x-admin.ckeditor label="" id="bodyEditor" name="body"></x-admin.ckeditor>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <x-admin.dropzone :action="route('upload')" formId="replyForm"></x-admin.dropzone>
                                    </div>
                                    <div class="mt-2">
                                        <input type="submit" class="btn btn-sm btn-success float-right"
                                            value="{{ __('el.button_reply') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                {{-- Reply Form --}}

                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('ticket.subject') }} : {{ $ticket->subject }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="card card-widget {{ $ticket->replies->count() ? 'collapsed-card' : null }}">
                                    <div class="card-header">
                                        <div class="user-block">
                                            <span
                                                class="username {{ $ticket->user->administrator ? 'text-success' : 'text-danger' }}">{{ $ticket->user->name }}</span>
                                            <span class="description">{{ $ticket->created_at->format('d/m/Y H:i:s') }}
                                                ({{ $ticket->date_added }})</span>
                                        </div>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i
                                                    class="fas {{ $ticket->replies->count() ? 'fa-plus' : 'fa-minus' }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool btnOpenModal"
                                                title="{{ __('notification.add') }}" data-target="#notificationModal"
                                                data-url="{{ route('notification.index', ['ticket', $ticket]) }}"
                                                data-widget="chat-pane-toggle">
                                                <i class="fas fa-comments"></i>
                                            </button>
                                            <span id="notifTicket{{ $ticket->id }}"
                                                class="badge badge-danger navbar-badge">{{ $ticket->notifications->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        {!! $ticket->body !!}
                                        @if ($ticket->getMedia('images')->count() || $ticket->getMedia('downloads')->count())
                                            <div class="attachment-block clearfix mt-2">
                                                <ul class="list-group">
                                                    @foreach ($ticket->getMedia('images') as $image)
                                                        <li><i class="fas fa-file-image mr-1"></i><a
                                                                href="{{ $image->getUrl() }}" data-toggle="lightbox"
                                                                data-gallery="example-gallery">{{ $image->file_name }}
                                                            </a></li>
                                                    @endforeach
                                                </ul>
                                                <ul class="list-group">
                                                    @foreach ($ticket->getMedia('downloads') as $download)
                                                        <li><i class="fas fa-file mr-1"></i><a
                                                                href="{{ $download->getUrl() }}"
                                                                target="__blank">{{ $download->file_name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @foreach ($ticket->replies as $reply)
                                    <div
                                        class="card card-widget {{ $reply->id !== $ticket->replies->last()->id ? 'collapsed-card' : null }}">
                                        <div class="card-header">
                                            <div class="user-block">
                                                <span
                                                    class="username {{ $reply->user->administrator ? 'text-success' : 'text-danger' }}">{{ $reply->user->name }}</span>
                                                <span class="description">{{ $reply->created_at->format('d/m/Y H:i:s') }}
                                                    ({{ $reply->human_date }})
                                                </span>
                                            </div>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i
                                                        class="fas {{ $reply->id !== $ticket->replies->last()->id ? 'fa-plus' : 'fa-minus' }}"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool btnOpenModal"
                                                    title="{{ __('notification.add') }}" data-target="#notificationModal"
                                                    data-url="{{ route('notification.index', ['reply', $reply]) }}"
                                                    data-widget="chat-pane-toggle">
                                                    <i class="fas fa-comments"></i>
                                                </button>
                                                <span id="notifReply{{ $reply->id }}"
                                                    class="badge badge-danger navbar-badge">{{ $reply->notifications->count() }}</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            {!! $reply->body !!}
                                            @if ($reply->getMedia('images')->count() || $reply->getMedia('downloads')->count())
                                                <div class="attachment-block clearfix mt-2">
                                                    <ul class="list-group">
                                                        @foreach ($reply->getMedia('images') as $image)
                                                            <li><i class="fas fa-file-image mr-1"></i><a
                                                                    href="{{ $image->getUrl() }}" data-toggle="lightbox"
                                                                    data-gallery="example-gallery">{{ $image->file_name }}
                                                                </a></li>
                                                        @endforeach
                                                    </ul>
                                                    <ul class="list-group">
                                                        @foreach ($reply->getMedia('downloads') as $download)
                                                            <li><i class="fas fa-file mr-1"></i><a
                                                                    href="{{ $download->getUrl() }}"
                                                                    target="__blank">{{ $download->file_name }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('ticket.info') }}</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <th>{{ __('ticket.ticket_id') }}</th>
                                                <td>{{ $ticket->ticket_id }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('ticket.date') }}</th>
                                                <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('admin/user/client.fullname') }}</th>
                                                <td>{{ $ticket->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('ticket.invoice') }}</th>
                                                <td>{{ $ticket->invoice->invoice_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('ticket.domain') }}</th>
                                                <td>{{ $ticket->invoice->domain }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('ticket.queue') }}</th>
                                                <td>{{ $ticket->queue->name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button id="replyButton"
                                    class="btn btn-primary btn-sm float-right">{{ __('el.button_reply') }}</button>
                            </div>
                        </div>

                        <form action="{{ route('ticket.update', $ticket) }}" id="editTicket" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('ticket.edit') }}</h3>
                                </div>
                                <div class="card-body">
                                    <x-admin.form.select :selected="$ticket->queue_id" label="{{ __('ticket.queue') }}"
                                        name="queue_id" :options="$queues"></x-admin.form.select>
                                    <button class="btn btn-sm btn-default float-right"
                                        type="submit">{{ __('el.button_save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <x-admin.form-modal id="notificationModal" size="lg" :title="__('client.edit_title')"></x-admin.form-modal>
        </div>
    </section>

@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/ekko-lightbox/ekko-lightbox.min.js') }}" defer></script>
    <script type="module">
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

        $('#replyButton').on('click', function() {
            $('#replyForm').toggle(700)
        })
    </script>
@endpush
