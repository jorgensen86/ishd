@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">#{{ $ticket->id }} - {{ $ticket->subject }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="time-label">
                                            <span class="bg-info">{{ $ticket->created_at }}</span>
                                        </div>
                                        <div id="ticket">
                                            <i class="fas fa-envelope bg-info"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i>
                                                    {{ $ticket->date_added }}</span>
                                                <h3 class="timeline-header">
                                                    <a href="javascript:void()" data-toggle="collapse" data-target="#ticketBody">{{ $ticket->user->name }}</a>
                                                </h3>
                                                <div id="ticketBody"
                                                    class="collapse{{ !$ticket->replies->count() ? ' show' : null }}">
                                                    <div class="timeline-body">
                                                        <div>
                                                            {!! $ticket->body !!}
                                                        </div>
                                                        {{-- <div class="timeline-image">
                                                            @foreach ($medias as $media)
                                                                {{ $media }}
                                                            @endforeach
                                                        </div> --}}
                                                    </div>
                                                    <div class="timeline-footer text-right">
                                                        <button data-target="#notificationModal" data-url="{{ route('notification.index', ['ticket', $ticket]) }}" class="btn btn-success btn-sm btnOpenModal">Σημειώσεις (<span id="notifTicket{{ $ticket->id }}">{{ $ticket->notifications->count() }}</span>)</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($ticket->replies as $reply)
                                            <div id="reply-{{ $reply->id }}">
                                                <i class="fas fa-envelope bg-info"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i>
                                                        {{ $reply->date_added }}</span>
                                                    <h3 class="timeline-header"><a href="javascript:void()"
                                                            data-toggle="collapse"
                                                            data-target="#replyBody{{ $reply->id }}">{{ $reply->user->name }}</a></h3>
                                                    <div id="replyBody{{ $reply->id }}"
                                                        class="collapse{{ $reply->id === $ticket->replies->last()->id ? ' show' : null }}">
                                                        <div class="timeline-body">{!! $reply->body !!}</div>
                                                        <div class="timeline-footer text-right">
                                                            <button data-target="#notificationModal" data-url="{{ route('notification.index', ['reply', $reply]) }}" class="btn btn-success btn-sm btnOpenModal">Σημειώσεις (<span id="notifReply{{ $reply->id }}">{{ $reply->notifications->count() }}</span>)</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div>
                                            <i class="fas fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Πληροφορίες Αιτήματος</h3>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-6">Ημερομηνία</dt>
                                        <dd class="col-sm-6">{{ $ticket->created_at }}</dd>
                                        <dt class="col-sm-6">Συμβόλαιο</dt>
                                        <dd class="col-sm-6">{{ $ticket->invoice_number }}</dd>
                                        <dt class="col-sm-6">Domain</dt>
                                        <dd class="col-sm-6">{{ $ticket->invoice->domain }}</dd>
                                        <dt class="col-sm-6">Πελάτης</dt>
                                        <dd class="col-sm-6">{{ $ticket->invoice->user->name }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Επεξεργασία Αιτήματος</h3>
                                </div>
                                <div class="card-body p-0">
                                    <button class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true"
                                        href="#" role="button">
                                        
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9" id="replyFrom">
                            <form action="{{ route('reply.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="ticket_id" value="{{ $ticket->id }}">
                                    <input type="text" name="author_id" value="{{ auth()->user()->user_id }}">
                                    <label>Μήνυμα</label>
                                    <x-admin.ckeditor :id="'bodyEditor'" :name="'body'"></x-admin.ckeditor>
                                    <input type="submit" value="save">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-admin.form-modal id="notificationModal" size="lg" :title="__('client.edit_title')"></x-admin.form-modal>
    </section>
@endsection
