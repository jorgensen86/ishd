@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
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
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __('ticket.subject') }} : {{ $ticket->subject }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card {{ $ticket->replies->count() ? 'collapsed-card' : null }}">
                                <div class="card-header">
                                    <h3 class="card-title"># {{ $ticket->ticket_id }} - {{ $ticket->user->name }}</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas {{ $ticket->replies->count() ? 'fa-plus' : 'fa-minus' }}"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" title="Contacts"
                                            data-widget="chat-pane-toggle">
                                            <i class="fas fa-comments"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! $ticket->body !!}
                                    @if ($ticket->getMedia('images')->count())
                                        <div class="attachment-block clearfix">
                                            @foreach ($ticket->getMedia('images') as $image)
                                                <a href="{{ $image->getUrl() }}" data-toggle="lightbox"
                                                    data-gallery="example-gallery">
                                                    <img class="attachment-img" src="{{ $image->getUrl() }}"
                                                        alt="Attachment Image">
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                    @foreach ($ticket->getMedia('downloads') as $download)
                                        <div class="attachment-block clearfix">
                                            <a href="{{ $download->getUrl() }}"
                                                target="__blank">{{ $download->file_name }}</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @foreach ($ticket->replies as $reply)
                                <div
                                    class="card {{ $reply->id !== $ticket->replies->last()->id ? 'collapsed-card' : null }}">
                                    <div class="card-header">
                                        <h3 class="card-title"># {{ $ticket->ticket_id }}/{{ $reply->id }} -
                                            {{ $reply->user->name }}
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i
                                                    class="fas {{ $reply->id !== $ticket->replies->last()->id ? 'fa-plus' : 'fa-minus' }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" title="Contacts"
                                                data-widget="chat-pane-toggle">
                                                <i class="fas fa-comments"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        {!! $reply->body !!}
                                        @if ($reply->getMedia('images')->count())
                                            <div class="attachment-block clearfix">
                                                @foreach ($reply->getMedia('images') as $image)
                                                    <a href="{{ $image->getUrl() }}" data-toggle="lightbox"
                                                        data-gallery="example-gallery">
                                                        <img class="attachment-img" src="{{ $image->getUrl() }}"
                                                            alt="Attachment Image">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        @foreach ($reply->getMedia('downloads') as $download)
                                            <div class="attachment-block clearfix">
                                                <a href="{{ $download->getUrl() }}"
                                                    target="__blank">{{ $download->file_name }}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('ticket.info') }}</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
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
                                <div class="card-footer">
                                    <button id="replyButton"
                                        class="btn btn-primary btn-sm float-right">{{ __('el.button_reply') }}</button>
                                </div>
                            </div>
                            <form action="{{ route('ticket.update', $ticket) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ __('ticket.edit') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <x-admin.form.select :selected="$ticket->queue_id" label="{{ __('ticket.queue') }}"
                                            name="queue_id" :options="$queues"></x-admin.form.select>
                                    </div>
                                    <div class="card-footer">
                                        <input type="submit" value="sss">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
