@extends('admin')

@section('content')
<x-admin.page-header :heading="$title"></x-admin.page-header>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <form action="{{ route('ticket.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>{{ __('admin/ticket.sender') }}</label>
                                <input type="text" name="author" id="inputAuthor" class="form-control" readonly="readonly" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="author_id" value="{{ auth()->user()->user_id }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('admin/ticket.recipient') }}</label>
                                <select data-allow-clear="true" data-placeholder="{{ __('el.text_select') }}" name="invoice_id" id="invoices"></select>
                            </div>
                            <div class="form-group">
                                <label for="inputSubject">{{ __('admin/ticket.subject') }}</label>
                                <input type="text" name="subject" id="inputSubject" value="" placeholder="{{ __('admin/ticket.subject') }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>dsadsa</label>
                                <x-admin.ckeditor :id="'bodyEditor'" :name="'body'"></x-admin.ckeditor>
                            </div>
                            <div class="pull-right">
                                <input type="submit" value="send">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form action="" method="post" name="file" files="true" enctype="multipart/form-data" class="dropzone" id="image-upload">
                    @csrf
                    <div>
                    <h3 class="text-center">Upload Multiple Images</h3>
                </div>    
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script type="module">
     Dropzone.options.imageUpload = {
            maxFilesize: 1,
            url: "http://dasdada.gr",
            acceptedFiles: ".jpeg,.jpg,.png,.gif"
        };
</script>
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