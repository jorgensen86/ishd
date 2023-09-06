@extends('admin')
@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content" id="ticketPage">
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('ticket.store') }}" method="post" id="ticketForm" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            {{-- Ticket Form --}}
                            <div class="col-md-8">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-form.select selected="" label="{{ __('ticket.sender') }}" name="queue_id" :options="$queues"></x-form.select>
                                    </div>
                                    <div class="col-md-6">
                                        <x-form.select2 label="{{ __('ticket.recipient') }}" name="invoice_id" id="invoices" options="" :multiple="false"></x-form.select>
                                    </div>
                                </div>
                                <x-form.text name="subject" id="inputSubject" placeholder="{{ __('ticket.subject') }}" value=""></x-form.text>
                                <x-.form.ckeditor label="{{ __('ticket.message') }}"  :id="'bodyEditor'" :name="'body'"></x-ckeditor>
                            </div>
                            {{--/ Ticket Form  --}}
                            
                            {{-- Dropzone --}}
                            <div class="col-md-4">
                                <x-admin.dropzone :action="route('upload')" formId="ticketForm"></x-admin.dropzone>
                                <div class="mt-2">
                                    <a href="{{ route('ticket.index', 1) }}" class="btn btn-sm btn-secondary">{{ __('el.button_cancel') }}</a>
                                    <input type="submit" class="btn btn-sm btn-success float-right" value="{{ __('el.button_send') }}">
                                </div>
                            </div>
                            {{--/ Dropzone --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@push('scripts')

<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" defer></script>
<script src="{{ asset('assets/plugins/select2/js/el.js') }}" defer></script>

<script type="module">
    $('#invoices').select2({
        placeholder: "Αναζήτηση με crm ή domain",
        width: '100%',
        theme: "classic",
        minimumInputLength: 3,
        language: "el",
        allowClear: true,
        ajax: {
            url: "{{ route('invoice.index') }}",
            dataType: "json",
            delay: 600,
            data: (params) => {
                return {
                    filter_invoice: params.term,
                };
            },
            processResults: function (json) {
                return {
                    results: $.map(json, function (item) {
                        return {
                            text: `${item.invoice_number}  ${item.user.name}`,
                            id: item.invoice_id
                        }
                    })
                };
            },
        },
    });
</script>
@endpush
