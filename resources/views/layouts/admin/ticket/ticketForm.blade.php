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
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>

    <script type="module">
 var path = "{{ route('invoice.index') }}";
 $('input[name=\'invoice_number\']').autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
                filter_invoice: request.term
            },
            success: function( json ) {
                response($.map(json, function(item) {
					return {
						label: item['invoice_number'] + ` - (${item.domain})`,
						value: item['invoice_id']
					}
				}));
                }
          });
        },
        select: function(event, item) {
            event.preventDefault();
            $('input[name=\'invoice_number\']').val(item.item['label']);
        }
      });

</script>
@endpush
