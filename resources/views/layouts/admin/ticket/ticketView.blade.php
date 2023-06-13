@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">#{{ $ticket->id }} - {{ $ticket->subject }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="time-label">
                                    <span class="bg-red">{{ $ticket->created_at }}</span>
                                </div>
                                <div id="a">
                                    <i class="fas fa-envelope bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ $ticket->date_added }}</span>
                                        <h3 class="timeline-header"><a href="#">{{ $ticket->user->name }}</a> sent you an email</h3>
                                        <div class="timeline-body">{{ $ticket->body }}</div>
                                        <div class="timeline-footer text-right">
                                            <a class="btn btn-primary btn-sm">Read more</a>
                                            <a class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($ticket->replies as $reply)
                                    <div id="reply-{{ $reply->id }}">
                                        <i class="fas fa-envelope bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> {{ $ticket->date_added }}</span>
                                            <h3 class="timeline-header"><a href="#">{{ $reply->user->name }}</a> sent you an email</h3>
                                            <div class="timeline-body">{{ $reply->body }}</div>
                                            <div class="timeline-footer text-right">
                                                <a class="btn btn-primary btn-sm">Read more</a>
                                                <a class="btn btn-danger btn-sm">Delete</a>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">dasd</h3>
                        </div>
                        <div class="card-body">
                            dasdasa
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>dasd</h3>
                        </div>
                        <div class="card-body">
                            dasdasa
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
