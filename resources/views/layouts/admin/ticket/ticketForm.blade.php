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
                                <x-admin.form.select2 label="{{ __('admin/ticket.sender') }}" name="invoice_number" id="invoices" inputName="queue_id" options="" :multiple="false"></x-admin.form.select>
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
