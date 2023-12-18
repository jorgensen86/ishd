<div class="modal-header bg-info">
    <h6 class="modal-title">{{ $title }}</h6>
</div>
<div class="modal-body">
    <form action="{{ $action }}" method="{{ $method }}" id="roleForm" autocomplete="false">
        @csrf

        <x-form.select label="{{ __('admin/email/imap.queue') }}" name="queue_id" :options="$queues" :selected="$data->queue_id"></x-form.select>
        <x-form.text name="host" id="input-host" placeholder="{{ __('admin/email/imap.host') }}" :value="$data->host"></x-form.text>
        <x-form.text name="username" id="input-username" placeholder="{{ __('admin/email/imap.username') }}" :value="$data->username"></x-form.text>
        <x-form.text name="password" id="input-password" placeholder="{{ __('admin/email/imap.password') }}" value=""></x-form.text>
        <x-form.text name="port" id="input-port" placeholder="{{ __('admin/email/imap.port') }}" :value="$data->port"></x-form.text>
        <div class="form-group">
            <label>{{  __('admin/email/imap.encryption') }}</label>
            <select name="encryption" class="form-control">
                <option value="">{{ __('el.text_no') }}</option>
                <option {{ $data->encryption === 'ssl' ? 'selected' : null }} value="ssl">Ssl</option>
                <option {{ $data->encryption === 'tls' ? 'selected' : null }} value="tls">Tls</option>
                <option {{ $data->encryption === 'starttls' ? 'selected' : null }} value="starttls">Starttls</option>
                <option {{ $data->encryption === 'notls' ? 'selected' : null }} value="notls">Notls</option>
            </select>
        </div>
        <div class="form-group">
            <label>{{  __('admin/email/imap.cert') }}</label>
            <select name="validate_cert" class="form-control">
                <option  {{ $data->validate_cert === 0 ? 'selected' : null }} value="0">{{ __('el.text_no') }}</option>
                <option  {{ $data->validate_cert === 1 ? 'selected' : null }} value="1">{{ __('el.text_yes') }}</option>
            </select>
        </div>

        <x-form.checkbox :active="$data->active" label="{{ __('user.status') }}"></x-form.checkbox>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('el.button_cancel') }}</button>
    <button type="button" id="btnSave" data-form="#roleForm"
        class="btn btn-sm btn-success">{{ __('el.button_save') }}</button>
</div>
