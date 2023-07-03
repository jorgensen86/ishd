<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="clientForm">
        @csrf
        <x-admin.form.input-group inputName="name" icon="fa-person" placeholder="{{ __('admin/user/client.fullname') }}"
            :value="$data->name"></x-admin.form.input-group>
        <x-admin.form.input-group inputName="email" icon="fa-envelope" placeholder="{{ __('admin/user/client.email') }}"
            :value="$data->email"></x-admin.form.input-group>
        <x-admin.form.input-group inputName="username" icon="fa-user"
            placeholder="{{ __('admin/user/client.username') }}" :value="$data->username"></x-admin.form.input-group>
        <x-admin.form.input-group inputName="password" icon="fa-lock"
            placeholder="{{ __('admin/user/client.password') }}" value=""></x-admin.form.input-group>
            <x-admin.form.select2 name="invoice[]" :multiple="true" id="invoices" label="{{ __('admin/user/client.invoice') }}" :options="$data->invoices"></x-admin.form.select2>
            <x-admin.form.checkbox :active="$data->active"></x-admin.form.checkbox>
        {{-- <div class="form-group">
            <select data-allow-clear="true" data-placeholder="{{ __('client.invoice') }}" name="invoice[]"
                id="invoices" multiple>
                @foreach ($data->invoices as $invoice)
                    <option value="{{ $invoice->invoice_id }}" @selected(true)>
                        {{ $invoice->invoice_number }} ({{ $invoice->domain }})</option>
                @endforeach
            </select>
        </div> --}}
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#clientForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>

<script type="module">
    $('#invoices').select2({
        width: '100%',
        allowClear: true,
        theme: "classic",
        minimumInputLength: 3,
        placeholder: "{{ __('el.text_select') }}",
        ajax: {
            url: "{{ route('invoice.index') }}",
            dataType: "json",
            delay: 600,
            data: (params) => {
                return { 
                    filter_invoice : params.term,
                    user_id : "{{ $data->user_id }}" 
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
