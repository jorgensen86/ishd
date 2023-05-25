<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="clientForm">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-person"></i></span>
            </div>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                placeholder="{{ __('client.fullname') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                placeholder="{{ __('client.email') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}"
                placeholder="{{ __('client.username') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="text" name="password" class="form-control" value="" placeholder="{{ __('client.password') }}">
        </div>
        <div class="custom-control custom-switch mb-3">
            <input type="checkbox" class="custom-control-input" id="inputActive" name="active" value="1" {{ $user->active ?
            'checked' : null }}>
            <label class="custom-control-label" for="inputActive">{{ __('el.enable') }}</label>
        </div>
        <div class="form-group">
            <select data-allow-clear="true" data-placeholder="{{ __('client.invoice') }}" name="invoice[]" id="invoices" multiple>
                @foreach ($user->invoices as $invoice)
                    <option value="{{ $invoice->invoice_id }}" @selected(true)>{{ $invoice->invoice_number }} ({{ $invoice->domain }})</option>
                @endforeach
            </select>
        </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#clientForm" class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>

<script type="module">
    $('#invoices').select2({
        multiple: true,
        width: '100%',
        theme: "classic",
        minimumInputLength: 3,
        ajax: {
            url: "{{ route('invoice.index') }}",
            dataType: "json",
            delay: 600,
            data: (params) => {
                return { 
                    filter_invoice : params.term,
                    user_id : "{{ $user->user_id }}" 
                };
            },
            processResults: function(json) {
                return {
                    results: $.map(json, function (item) {
                        return {
                            text: item.invoice_number,
                            disabled: item.user_id ? 'disabled' : null,
                            id: item.invoice_id
                        }
                    })
                };
            },
        },
    });
</script>