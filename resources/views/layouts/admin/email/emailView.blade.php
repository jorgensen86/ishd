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
                                    <h3 class="card-title">#{{ $data->ticket_id }} - {{ $data->subject }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="time-label">
                                            <span class="bg-info">{{ $data->created_at }}</span>
                                        </div>
                                        <div id="ticket">
                                            <i class="fas fa-envelope bg-info"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i>
                                                    {{ $data->date_added }}</span>
                                                <h3 class="timeline-header">
                                                    <a href="javascript:void()" data-toggle="collapse" data-target="#ticketBody">{{ $data->sender }}</a>
                                                </h3>
                                                <div id="ticketBody"
                                                    class="collapse show">
                                                    <div class="timeline-body">
                                                        <div>
                                                            {!! $data->body !!}
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-admin.form-modal id="notificationModal" size="lg" :title="__('client.edit_title')"></x-admin.form-modal>
    </section>
@endsection
