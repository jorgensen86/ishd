@extends('client')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-info card-outline {{ $ticket->replies->count() ? 'collapsed-card' : null }}">
                <div class="card-header">
                    <h3 class="card-title"># {{ $ticket->ticket_id }} - {{ $ticket->subject }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas {{ $ticket->replies->count() ? 'fa-plus' : 'fa-minus' }}"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {!! $ticket->body !!}
               
                </div>
            </div>
            @foreach ($ticket->replies as $reply)
                <div class="card card-info card-outline {{ $reply->id !== $ticket->replies->last()->id ? 'collapsed-card' : null }}">
                    <div class="card-header">
                        <h3 class="card-title"># {{ $ticket->ticket_id }}/{{ $reply->id }} - {{ $reply->user->name }}
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas {{ $reply->id !== $ticket->replies->last()->id ? 'fa-plus' : 'fa-minus' }}"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $reply->body !!}
                      
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/ekko-lightbox/ekko-lightbox.min.js') }}" defer></script>
    <script type="module">
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
     </script>
@endpush
