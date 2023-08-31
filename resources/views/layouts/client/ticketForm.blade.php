@extends('client')
@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content" id="ticketPage">
        <div class="container-fluid">
            <div class="card card-outline card-info">
                <form action="{{ route('client.ticket.store') }}" method="post" id="ticketForm">
                    <div class="overlay-wrapper">
                        <x-form.overlay></x-form.overlay>
                        <div class="card-body">
                            <div class="row">
                                {{-- Ticket Form --}}
                                <div class="col-md-8">
                                    @csrf
                                    <x-form.select selected="" label="{{ __('ticket.domain') }}" name="domain_id"
                                        :options="$invoices"></x-form.select>
                                    <x-form.select selected="" label="{{ __('ticket.group') }}" name="subject_id"
                                        :options="$subjects"></x-form.select>
                                    <x-form.text name="subject" id="inputSubject" placeholder="{{ __('ticket.subject') }}"
                                        value=""></x-form.text>
                                    <x-form.ckeditor label="{{ __('ticket.message') }}" :id="'bodyEditor'"
                                        :name="'body'"></x-form.ckeditor>
                                </div>
                                {{-- / Ticket Form  --}}

                                {{-- Dropzone --}}
                                <div class="col-md-4">
                                    <x-admin.dropzone :action="route('upload')" formId="ticketForm"></x-admin.dropzone>
                                    <div class="mt-2">
                                        <a href="{{ route('ticket.index', 1) }}"
                                            class="btn btn-sm btn-secondary">{{ __('el.button_cancel') }}</a>
                                        <input type="submit" class="btn btn-sm btn-success float-right"
                                            value="{{ __('el.button_send') }}">
                                    </div>
                                </div>
                                {{-- / Dropzone --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
