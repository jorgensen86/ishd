<div class="form-group">
    <label for="{{ $id }}">{{ __('client.invoice') }}</label>
    <select data-allow-clear="true" name="{{ $name }}" id="{{ $id }}">
        @if ($options)
        @foreach ($options as $option)
        {{-- <option value="{{ $option->option_id }}">{{ $option->option_number }} ({{ $option->domain }})</option> --}}
        @endforeach
        @endif
    </select>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" defer></script>
<script src="{{ asset('assets/plugins/select2/js/el.js') }}" defer></script>
<script type="module">
    $('#{{ $id }}').select2({
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