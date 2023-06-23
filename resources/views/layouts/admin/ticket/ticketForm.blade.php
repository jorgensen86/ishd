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
                                <x-admin.form.select label="{{ __('admin/ticket.sender') }}" inputName="queue_id"
                                    :options="$queues"></x-admin.form.select>
                                {{-- <x-admin.form.select label="{{ __('admin/ticket.recipient') }}" inputName="invoice_id" :options="[]"></x-admin.form.select> --}}
                                <div class="form-group">
                                    <label>{{ __('admin/ticket.recipient') }}</label>
                                    <select data-allow-clear="true" data-placeholder="{{ __('el.text_select') }}"
                                        name="invoice_id" id="invoices"></select>
                                </div>
                                <x-admin.form.text inputName="subject" labelFor="inputSubject"
                                    placeholder="{{ __('admin/ticket.subject') }}" :value="''"></x-admin.form.text>
                                <div class="form-group">
                                    <label>dsadsa</label>
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
@push('scripts')
    <script type="module">
    $('#invoices').select2({
        width: '100%',
        theme: "classic",
        minimumInputLength: 3,
        allowClear: true,
        ajax: {
            url: "{{ route('invoice.index') }}",
            dataType: "json",
            delay: 600,
            data: (params) => {
                return { 
                    filter_invoice : params.term,
                };
            },
            processResults: function(json) {
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
