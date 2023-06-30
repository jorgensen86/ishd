@extends('admin')
@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-info">
                <form action="{{ route('ticket.store') }}" method="post" id="ticketForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                @csrf
                                <input type="hidden" name="author_id" value="{{ auth()->user()->user_id }}">
                                <input type="hidden" name="author" value="{{ auth()->user()->name }}">
                                <x-admin.form.select selected="" label="{{ __('admin/ticket.sender') }}" inputName="queue_id"
                                    :options="$queues"></x-admin.form.select>
                                <x-admin.form.select2 label="{{ __('admin/ticket.sender') }}" name="invoice_number" :id="'invoiceNumber'" inputName="queue_id" options=""></x-admin.form.select>
                                <x-admin.form.text inputName="subject" labelFor="inputSubject"
                                    placeholder="{{ __('admin/ticket.subject') }}" :value="''"></x-admin.form.text>
                                <div class="form-group">
                                    <label>{{ __('admin/ticket.message') }}</label>
                                    <x-admin.ckeditor :id="'bodyEditor'" :name="'body'"></x-admin.ckeditor>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <x-admin.dropzone :action="route('upload')" formId="ticketForm"></x-admin.dropzone>
                                <div class="mt-2">
                                    <a href="{{ route('ticket.index', 1) }}" class="btn btn-sm btn-secondary">{{ __('el.button_cancel') }}</a>
                                    <input type="submit" class="btn btn-sm btn-success float-right" value="{{ __('el.button_save') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </section>
@endsection
